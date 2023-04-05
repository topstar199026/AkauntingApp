<?php

namespace Modules\CreditDebitNotes\Http\ViewComposers\Invoice;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Modules\CreditDebitNotes\Services\Credits;

class AdjustAmountDueInDetails
{
    /**
     * @var Credits
     */
    private $credits;

    public function __construct(Credits $credits)
    {
        $this->credits = $credits;
    }

    public function compose(View $view)
    {
        if (!$route_name = Route::currentRouteName()) {
            return;
        }

        $routes = [
            'invoices.show',
            'signed.invoices.show',
            'portal.invoices.show',
        ];

        if (!in_array($route_name, $routes)) {
            return;
        }

        $view_data = $view->getData();

        $invoice = $view_data['document'];

        $applied_credits = $this->credits->getAppliedCredits($invoice);

        $description = trans('general.amount_due') . ': ' . '<span class="font-medium">' . money($invoice->amount_due - $applied_credits, $invoice->currency_code, true) . '</span>';

        $view->with(['description' => $description]);
    }
}
