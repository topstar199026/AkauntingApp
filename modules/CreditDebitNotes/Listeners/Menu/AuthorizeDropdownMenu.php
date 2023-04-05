<?php

namespace Modules\CreditDebitNotes\Listeners\Menu;

use App\Events\Menu\ItemAuthorizing as Event;

class AuthorizeDropdownMenu
{
    public function handle(Event $event)
    {
        // Sales -> Credit Notes
        if ($event->item->title === trim(trans_choice('general.sales', 2))) {
            $event->item->permissions[] = 'read-credit-debit-notes-credit-notes';
        }

        // Purchases -> Debit Notes
        if ($event->item->title === trim(trans_choice('general.purchases', 2))) {
            $event->item->permissions[] = 'read-credit-debit-notes-debit-notes';
        }
    }
}
