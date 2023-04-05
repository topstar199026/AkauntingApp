<?php

namespace Modules\Helpdesk\Listeners;

use App\Events\Menu\PortalCreated as Event;
use App\Models\Module\Module;

class AddToPortalMenu
{
    /**
     * Handle the event.
     *
     * @param PortalCreated $event
     * @return void
     */
    public function handle(Event $event)
    {
        $module = Module::alias('helpdesk')->enabled()->first();

        if (!$module) {
            return;
        }

        if (user()->cannot('read-helpdesk-portal-tickets')) {
            return;
        }

        $event->menu->add([
            'route' => ['portal.helpdesk.tickets.index', []],
            'title' => trans('helpdesk::general.name'),
            'icon' => 'checklist',
            'order' => 40,
        ]);
    }
}
