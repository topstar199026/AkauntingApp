<?php

namespace Modules\Receipt\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Models\Banking\Account;
use App\Traits\Transactions as TransactionsTrait;
use  Modules\Receipt\Exports\Receipts as Export;
use App\Jobs\Banking\CreateTransaction;
use App\Jobs\Banking\UpdateTransaction;
use App\Models\Banking\Transaction;
use App\Models\Common\Contact;
use App\Models\Setting\Category;
use App\Models\Setting\Currency;
use App\Traits\Uploads;
use App\Utilities\Modules;
use Date;
use Modules\Receipt\Http\Requests\Receipt;
use Modules\Receipt\Http\Requests\Import as ImportRequest;
use Modules\Receipt\Jobs\MindeeJob;
use Modules\Receipt\Jobs\TaggunJob;
use Modules\Receipt\Models\Receipt as ReceiptModel;
use Modules\Receipt\Traits\Api;
use Illuminate\Support\Facades\Storage;

class Receipts extends Controller
{
    use Api, Uploads, TransactionsTrait;

    public function index()
    {
        $api_key = setting('receipt.api_key', '');

        if (empty($api_key)) {
            return redirect()->route('receipt.setting');
        }

        $receipts = ReceiptModel::with(['contact'])->collect(['created_at' => 'desc']);

        return view('receipt::receipt.index', compact('receipts'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('receipt::receipt.create');
    }

    /**
     * @param ImportRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImportRequest $request)
    {
        $media = $this->getMedia($request->file('attachment'), 'receipts');

        $file = Storage::get($media->getDiskPath());

        $create_date = Date::now();

        $receipt = [
            'company_id' => company_id(),
            'date' => $create_date,
            'create_date' => $create_date,
            'merchant' => trans('general.na'),
            'statuses' => trans('document.statuses.pending'),
            'total_amount' => 0,
            'currency_code' => setting('default.currency'),
            'tax_amount' => 0,
            'payment_id' => 0,
            'payment_method' => '',
            'image' => base64_encode($file),
            'file_name' => $media->filename
        ];

        $receiptModel = ReceiptModel::create($receipt);

        $message = trans('messages.success.added', ['type' => trans('receipt::general.title')]);

        $response = [
            'success' => true,
            'error' => false,
            'data' => [],
            'message' => $message,
            'redirect' => route('receipt.index')
        ];

        if (setting('receipt.platform', 'taggun') == 'taggun') {
            $this->dispatch(new TaggunJob(Storage::path($media->getDiskPath()), $receiptModel));
        } elseif (setting('receipt.platform') == 'mindee') {
            $this->dispatch(new MindeeJob($file, $receiptModel));
        } else {
            $message = trans('messages.error.invalid_apikey');

            $response = [
                'success' => false,
                'error' => true,
                'data' => [],
                'message' => $message,
                'redirect' => route('receipt.index')
            ];

            flash($message)->error();

            return response()->json($response);
        }

        flash($message)->success();

        return response()->json($response);
    }

    public function import()
    {
        return view('receipt::receipt.import');
    }

    /**
     * @param ReceiptModel $receipt
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(ReceiptModel $receipt)
    {
        $payment_methods = Modules::getPaymentMethods();
        $image = base64_decode($receipt->image);

        $type = request()->get('type', 'expense');
        $contact_type = config('type.transaction.' . $type . '.contact_type');
        $account_currency_code = Account::where('id', setting('default.account'))->pluck('currency_code')->first();
        $currency = Currency::where('code', $account_currency_code)->first();

        $f = finfo_open();
        $mime_type = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);

        return view('receipt::receipt.edit', compact(
            'receipt',
            'payment_methods',
            'image',
            'currency',
            'mime_type',
            'type',
            'account_currency_code',
            'contact_type',
            'currency'
        ));
    }

    public function update(ReceiptModel $receipt, Receipt $request)
    {
        $request->merge([
            'statuses' => trans('documents.statuses.approved'),
            'tax_amount' => $request->tax_amount ?? 0,
            'currency' => $request->currency
        ]);
        $receipt->update($request->all());

        if ($receipt->payment_id != 0) {
            $transaction = Transaction::find($receipt->payment_id);
            if ($transaction) {
                $create_payment = $this->paymentUpdate($transaction, $request);
            } else {
                $create_payment = $this->paymentSave($request);
            }
        } else {
            $create_payment = $this->paymentSave($request);
        }

        if (isset($create_payment['data'])) {
            $receipt->payment_id = $create_payment['data']->id;
            $receipt->update();
        }

        $message = trans('messages.success.updated', ['type' => trans('receipt::general.title')]);

        $response = [
            'success' => true,
            'error' => false,
            'data' => [],
            'message' => $message,
            'redirect' => route('receipt.index')
        ];

        flash($message)->success();

        return response()->json($response);
    }

    /**
     * @param ReceiptModel $receipt
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(ReceiptModel $receipt)
    {
        $receipt->delete();
        $message = trans('messages.success.deleted', ['type' => trans('receipt::general.title')]);

        $response = [
            'success' => true,
            'error' => false,
            'data' => [],
            'message' => $message,
            'redirect' => route('receipt.index')
        ];

        flash($message)->success();

        return response()->json($response);
    }

    public function paymentSave($request)
    {
        $request->merge([
            'company_id' => company_id(),
            'type' => 'expense',
            'number' =>  $this->getNextTransactionNumber(),
            'account_id' => setting('default.account'),
            'paid_at' => $request->date,
            'amount' => $request->total_amount,
            'currency_code' => setting('default.currency'),
            'currency_rate' => '1',
            'contact_id' => $request->contact_id,
            'description' => 'Date: '.$request->date . "\n".' Merchant: ' . $request->merchant . "\n" . 'Module: Receipt Import',
            'category_id' => $request->category_id,
            'payment_method' => $request->payment_method,
        ]);

        return $this->ajaxDispatch(new CreateTransaction($request));
    }

    public function paymentUpdate($transaction, $request)
    {
        $request->merge([
            'paid_at' => $request->date,
            'amount' => $request->total_amount,
            'contact_id' => $request->contact_id,
            'category_id' => $request->category_id,
            'description' => 'Date: '.$request->date . "\n".' Merchant: ' . $request->merchant . "\n" . 'Module: Receipt Import',
            'payment_method' => $request->payment_method,
        ]);

        return $this->ajaxDispatch(new UpdateTransaction($transaction, $request));
    }

    public function export()
    {
        return $this->exportExcel(new Export, trans_choice('receipt::general.title', 2));
    }
}
