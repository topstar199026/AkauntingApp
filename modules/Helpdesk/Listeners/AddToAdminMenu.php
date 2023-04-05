<?php

namespace Modules\Helpdesk\Listeners;

use App\Events\Menu\AdminCreated as Event;
use App\Models\Module\Module;
use App\Traits\Permissions;

class AddToAdminMenu
{
    use Permissions;

    /**
     * Handle the event.
     *
     * @param AdminCreated $event
     * @return void
     */
    public function handle(Event $event)
    {
        $module = Module::alias('helpdesk')->enabled()->first();

        if (!$module) {
            return;
        }

        if (user()->cannot('read-helpdesk-tickets')) {
            return;
        }

        $event->menu->add([
            'route' => ['helpdesk.tickets.index', []],
            'title' => trans('helpdesk::general.name'),
            'icon' => 'checklist',
            'order' => 65,
        ]);
    }
}
