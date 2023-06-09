<?php

namespace Modules\CreditDebitNotes\Listeners\Menu;

use App\Events\Menu\PortalCreated;
use App\Traits\Permissions;

class AddPortalMenu
{
    use Permissions;

    public function handle(PortalCreated $event)
    {
        // Credit Notes
        $title = trans_choice('credit-debit-notes::general.credit_notes', 2);
        if ($this->canAccessMenuItem($title, 'read-credit-debit-notes-portal-credit-notes')) {
            $event->menu->add([
                'url' => route('portal.credit-debit-notes.credit-notes.index'),
                'title' => $title,
                'icon' => 'fas fa-file-invoice',
                'order' => 25,
            ]);
        }
    }
}
