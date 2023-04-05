<?php

namespace Modules\Helpdesk\Listeners;

use App\Events\Menu\NewwCreated;
use App\Traits\Permissions;

class AddToNewwMenu
{
    use Permissions;

    /**
     * Handle the event.
     *
     * @param NewwCreated $event
     * @return void
     */
    public function handle(NewwCreated $event)
    {
        $menu = $event->menu;

        $title = trim(trans('helpdesk::general.name'));
        if ($this->canAccessMenuItem($title, 'create-helpdesk-tickets')) {
            $menu->route('helpdesk.tickets.create', $title, [], 80, ['icon' => 'checklist']);
        }
    }
}
