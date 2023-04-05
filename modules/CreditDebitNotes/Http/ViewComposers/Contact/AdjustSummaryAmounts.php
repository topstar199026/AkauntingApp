<?php

namespace Modules\CreditDebitNotes\Http\ViewComposers\Contact;

use App\Models\Common\Contact;
use App\Utilities\Date;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;
use Modules\CreditDebitNotes\Models\CreditsTransaction;

class AdjustSummaryAmounts
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view): void
    {
        $totals = [
            'paid'    => 0,
            'open'    => 0,
            'overdue' => 0,
        ];

        $viewData = $view->getData();

        $contact = $viewData['contact'];

        if ($contact->type !== Contact::CUSTOMER_TYPE) {
            return;
        }

        $credits_transactions = CreditsTransaction::with('credit_note.invoice')
            ->income()
            ->where('contact_id', $contact->id)
            ->get();

        $today = Date::today()->toDateString();

        foreach ($credits_transactions as $credits_transaction) {
            $credits_amount = $credits_transaction->getAmountConvertedToDefault();

            if (!$invoice = optional($credits_transaction->credit_note)->invoice) {
                $totals['paid'] -= $credits_amount;

                continue;
            }

            // Check if it's open or overdue invoice
            if ($invoice->due_at > $today) {
                $totals['open'] += $credits_amount;
            } else {
                $totals['overdue'] += $credits_amount;
            }
        }

        $summary_amounts = $viewData['summary_amounts'];

        foreach (array_keys($totals) as $type) {
            $amount = money($summary_amounts["{$type}_exact"], default_currency(), true)
                ->subtract(money($totals[$type], default_currency(), true));

            $summary_amounts["{$type}_exact"] = $amount->format();
            $summary_amounts["{$type}_for_humans"] = $amount->formatForHumans();
        }

        $view->with(['summary_amounts' => $summary_amounts]);
    }

    public function paginate($items, $perPage = null, $page = null, $options = []): LengthAwarePaginator
    {
        $perPage = $perPage ?: request('limit', setting('default.list_limit', '25'));

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
