<?php

namespace Modules\Receipt\Listeners;

use App\Events\Menu\ItemAuthorizing as Event;
use App\Traits\Modules;

class AuthorizeDropdownMenu
{
    use Modules;

    public function handle(Event $event)
    {
        if ($this->moduleIsDisabled('receipt')) {
            return;
        }

        if ($event->item->title === trim(trans_choice('general.purchases', 2))) {
            $event->item->permissions[] = 'read-receipt-receipts';
        }
    }
}
