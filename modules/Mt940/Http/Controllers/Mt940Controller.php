<?php
namespace Modules\Mt940\Http\Controllers;

use App\Jobs\Banking\CreateAccount;
use App\Jobs\Banking\CreateTransaction;
use App\Jobs\Setting\CreateCurrency;
use App\Models\Banking\Account;
use App\Models\Setting\Category;
use App\Models\Setting\Currency;
use App\Traits\Jobs;
use App\Traits\Transactions;
use App\Traits\Uploads;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Kingsquare\Banking\Statement;
use Kingsquare\Parser\Banking\Mt940;
use Modules\Mt940\Http\Requests\BankAccount as Request;
use Modules\Mt940\Http\Requests\Mt940Import;

class Mt940Controller extends Controller
{
    use Jobs, Uploads, Transactions;

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('mt940::create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createBank()
    {
        return view('mt940::bank');
    }

    public function import(Mt940Import $request)
    {
        $media = $this->getMedia($request->file('import'), 'mt940');

        try {
            $parsedAllStatements = (new Mt940())->parse($media->contents());
            $parsedStatement = $parsedAllStatements[0];

            $response = [
                'success' => true,
                'error' => false,
                'data' => null,
                'message' => trans('mt940::general.success')
            ];

            foreach ($parsedAllStatements as $parsedStatement) {
                $currenyCode = $this->createCurrency($parsedStatement->getCurrency());

                if ($this->checkBankAccount($parsedStatement)) {
                    $this->insertAccount($currenyCode->getAttribute('code'), $parsedStatement->getAccount(), $parsedStatement->getBank());
                }

                $this->processStatement($parsedStatement);
            }

            flash(trans('mt940::general.success'))->success();

            $response['redirect'] = route('mt940.create');

            // if ($this->checkBankAccount($parsedAllStatements[0])) {
            //     session([
            //         'mt940_path' => $media,
            //         'parsedStatement' => $parsedAllStatements[0],
            //         'parsedAllStatements' => $parsedAllStatements,
            //     ]);

                // return view('mt940::bank', compact('parsedStatement'));
                // return redirect()->route('mt940.create.bank')->with('parsedStatement', $parsedStatement);
                // return redirect()->action('Mt940Controller@createBank', ['parsedStatement' => $parsedStatement]);

            //     $response['redirect'] = route('mt940.create.bank');
            // } else {
            //     foreach ($parsedAllStatements as $parsedStatement) {
            //         $this->processStatement($parsedStatement);
            //     }

            //     $response['redirect'] = route('mt940.create');

            //     $message = trans('mt940::general.success');

            //     flash($message)->success();
            // }
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
                'redirect' => route('mt940.create'),
            ];

            $message = trans('mt940::general.error');

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function createBankAccount(Request $request)
    {
        $parsedStatement = session('parsedStatement');
        $parsedAllStatements = session('parsedAllStatements');
        $currenyCode = $this->createCurrency($parsedStatement->getCurrency());
        $this->insertAccount($currenyCode->getAttribute('code'), $request->bankId, $request->bankName);

        $response = [
            'success' => false,
            'error' => true,
            'data' => null,
            'redirect' => route('mt940.create'),
        ];

        try {
            foreach ($parsedAllStatements as $parsedStatement) {
                $this->processStatement($parsedStatement);
            }

            flash(trans('mt940::general.success'))->success();
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();

            flash($e->getMessage())->error()->important();
        }

        return response()->json($response);
    }

    protected function checkBankAccount(Statement $statement)
    {
        $isExist = false;

        $account = Account::where('number', $statement->getAccount())
            ->first();
        $isExist = empty($account);

        return $isExist;
    }

    protected function processStatement(Statement $statement)
    {
        $company_id = company_id();

        foreach ($statement->getTransactions() as $transaction) {
            $price = $transaction->getPrice();
            $description = $transaction->getDescription();
            $transactionDate = $transaction->getEntryTimestamp('Y-m-d');
            $currency = $statement->getCurrency();
            $account = Account::where('number', $statement->getAccount())->first();
            $number = $this->getNextTransactionNumber();

            if ($transaction->getDebitCredit() == 'D') {
                $this->insertPayment($price, $description, $transactionDate, $company_id, $currency, $account->id, $number);
            } else {
                $this->insertRevenue($price, $description, $transactionDate, $company_id, $currency, $account->id, $number);
            }
        }
    }

    protected function createCurrency($code)
    {
        $currency = Currency::where('code', (string) $code)->first();

        if (empty($currency)) {
            $c = currency(strtoupper((string) $code));

            $data = [
                'company_id' => company_id(),
                'code' => (string) $code,
                'name' => $c->getName(),
                'rate' => '1', // boş olmayabilir
                'precision' => $c->getPrecision(),
                'symbol_first' => $c->isSymbolFirst(),
                'decimal_mark' => $c->getDecimalMark(),
                'thousands_separator' => $c->getThousandsSeparator(),
                'enabled' => '1',
                'default_currency' => '0',
                'created_from' => source_name('mt940'),
            ];

            $currency = $this->dispatch(new CreateCurrency($data));
        }

        return $currency;
    }

    protected function insertAccount($currencCode, $bankId, $bankName)
    {
        $bankControl = '';
        $results = Account::where('number', $bankId)->first();

        if (empty($results)) {
            $bankAdd = [
                'name' => $bankName,
                'number' => $bankId,
                'company_id' => company_id(),
                'currency_code' => $currencCode,
                'opening_balance' => '0',
                'enabled' => '1',
                'created_from' => source_name('mt940'),
            ];

            $bankControl = $this->dispatch(new CreateAccount($bankAdd));
        } else {
            $bankControl = $results;
        }

        return $bankControl;
    }

    protected function insertRevenue($amount, $description, $transactionDate, $companyId, $currency, $accountId, $number)
    {
        $revenue = [
            'company_id' => $companyId,
            'type' => 'income',
            'number' => $number,
            'account_id' => $accountId,
            'paid_at' => $transactionDate,
            'amount' => $amount,
            'currency_code' => $currency,
            'currency_rate' => '1',
            'description' => $description,
            'category_id' => Category::enabled()->type('income')
                ->pluck('id')
                ->first(),
            'payment_method' => setting('default.payment_method'),
            'created_from' => source_name('mt940'),
        ];

        $this->dispatch(new CreateTransaction($revenue));
    }

    protected function insertPayment($amount, $description, $transactionDate, $companyId, $currency, $accountId, $number)
    {
        $expenses = [
            'company_id' => $companyId,
            'type' => 'expense',
            'number' => $number,
            'account_id' => $accountId,
            'paid_at' => $transactionDate,
            'amount' => $amount,
            'currency_code' => $currency,
            'currency_rate' => '1',
            'description' => $description,
            'category_id' => Category::enabled()->type('expense')
                ->pluck('id')
                ->first(),
            'payment_method' => setting('default.payment_method'),
            'created_from' => source_name('mt940'),
        ];

        $this->dispatch(new CreateTransaction($expenses));
    }
}
