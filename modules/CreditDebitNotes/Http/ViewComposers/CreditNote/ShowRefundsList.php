<?php

namespace Modules\CreditDebitNotes\Http\ViewComposers\CreditNote;

use App\Models\Banking\Transaction;
use Illuminate\View\View;
use Modules\CreditDebitNotes\Models\CreditNote;

class ShowRefundsList
{
    public function compose(View $view)
    {
        $view_data = $view->getData();

        if ($view_data['type'] !== CreditNote::TYPE) {
            return;
        }

        $credit_note = $view_data['document'];

        if ($credit_note->credit_customer_account) {
            return;
        }

        $refunds = Transaction::documentId($credit_note->id)->get();

        // TODO: adjust for a case with different currencies in transactions
        $amount_available = $credit_note->amount - $refunds->sum('amount');

        $view_data['description'] = trans('credit-debit-notes::credit_notes.amount_available') . ': ' . '<span class="font-medium">' . money($amount_available, $credit_note->currency_code, true) . '</span>';
        $view_data['amount_available'] = $amount_available;

        $view->getFactory()->startPush(
            'get_paid_start',
            view('credit-debit-notes::partials.credit_note.refunds_list', $view_data)
        );
    }
}
