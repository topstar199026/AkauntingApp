<?php

namespace Modules\CreditDebitNotes\Listeners\Menu;

use App\Events\Menu\AdminCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class AddAdminMenu
{
    use Permissions, Modules;

    public function handle(Event $event): void
    {
        if (!$this->moduleIsEnabled('credit-debit-notes')) {
            return;
        }

        $menu = $event->menu;

        // Sales -> Credit Notes
        $title = trim(trans_choice('general.sales', 2));

        if ($item = $menu->whereTitle($title)) {
            if ($this->canAccessMenuItem($title, 'read-credit-debit-notes-credit-notes')) {
                $item->url(
                    route('credit-debit-notes.credit-notes.index'),
                    trans_choice('credit-debit-notes::general.credit_notes', 2),
                    25,
                    []
                );
            }
        }

        // Purchases -> Debit Notes
//        $title = trim(trans_choice('general.purchases', 2));
//
//        if ($item = $menu->whereTitle($title)) {
//            if ($this->canAccessMenuItem($title, 'read-credit-debit-notes-debit-notes')) {
//                $item->url(
//                    route('credit-debit-notes.debit-notes.index'),
//                    trans_choice('credit-debit-notes::general.debit_notes', 2),
//                    25,
//                    []
//                );
//            }
//        }
    }
}
