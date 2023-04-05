<?php

namespace Modules\CreditDebitNotes\Http\ViewComposers\DebitNote;

use Illuminate\View\View;
use Modules\CreditDebitNotes\Models\DebitNote;

class ShowReceiveRefundButton
{
    public function compose(View $view)
    {
        $view_data = $view->getData();

        if ($view_data['type'] !== DebitNote::TYPE) {
            return;
        }

        if ($view_data['document']->status !== 'sent') {
            return;
        }

        $view->getFactory()->startPush(
            'add_new_button_start',
            view('credit-debit-notes::partials.debit_note.receive_refund_button')
        );
    }
}
