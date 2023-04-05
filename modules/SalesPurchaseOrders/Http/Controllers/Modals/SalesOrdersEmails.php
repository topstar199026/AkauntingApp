<?php

namespace Modules\SalesPurchaseOrders\Http\Controllers\Modals;

use App\Abstracts\Http\Controller;
use App\Jobs\Document\SendDocumentAsCustomMail;
use App\Http\Requests\Common\CustomMail as Request;
use Illuminate\Http\JsonResponse;
use Modules\SalesPurchaseOrders\Models\SalesOrder\Model;
use Modules\SalesPurchaseOrders\Notifications\SalesOrder as Notification;

class SalesOrdersEmails extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-sales-purchase-orders-sales-orders')->only('create', 'store');
    }

    public function create(Model $salesOrder): JsonResponse
    {
        $notification = new Notification($salesOrder, 'sales_order_new_customer', true);

        $html = view('sales-purchase-orders::sales_orders.modals.email', compact('salesOrder', 'notification'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => 'null',
            'html'    => $html,
            'data'    => [
                'title'   => trans('general.title.new', ['type' => trans_choice('general.email', 1)]),
                'buttons' => [
                    'cancel'  => [
                        'text'  => trans('general.cancel'),
                        'class' => 'btn-outline-secondary',
                    ],
                    'confirm' => [
                        'text'  => trans('general.send'),
                        'class' => 'disabled:bg-green-100',
                    ],
                ],
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new SendDocumentAsCustomMail($request, 'sales_order_new_customer'));

        if ($response['success']) {
            $salesOrder = Model::find($request->get('document_id'));

            $response['redirect'] = route('sales-purchase-orders.sales-orders.show', $salesOrder->id);

            $message = trans(
                'documents.messages.email_sent',
                ['type' => trans_choice('sales-purchase-orders::general.sales_orders', 1)]
            );

            flash($message)->success();
        } else {
            $response['redirect'] = null;
        }

        return response()->json($response);
    }
}
