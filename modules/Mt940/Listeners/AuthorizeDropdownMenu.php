<?php

namespace Modules\Mt940\Listeners;

use App\Events\Menu\ItemAuthorizing as Event;
use App\Traits\Modules;

class AuthorizeDropdownMenu
{
    use Modules;

    public function handle(Event $event)
    {
        if ($this->moduleIsDisabled('mt940')) {
            return;
        }

        if ($event->item->title === trim(trans_choice('general.banking', 2))) {
            $event->item->permissions[] = 'read-mt940';
        }
    }
}