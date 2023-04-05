<?php

namespace Modules\Proposals\Listeners;

use App\Events\Menu\ItemAuthorizing as Event;
use App\Traits\Modules;

class AuthorizeDropdownMenu
{
    use Modules;

    public function handle(Event $event)
    {
        if ($this->moduleIsDisabled('proposals')) {
            return;
        }

        if ($event->item->title === trim(trans_choice('general.sales', 2))) {
            $event->item->permissions[] = 'read-proposals-proposals';
        }
    }
}
