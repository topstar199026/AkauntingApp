<?php

namespace Modules\Projects\Listeners;

use App\Events\Menu\PortalCreated as Event;
use App\Traits\Modules;

class AddPortalMenu
{
    use Modules;

    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($this->moduleIsDisabled('projects')) {
            return;
        }

        if (user()->cannot('read-projects-portal-projects')) {
            return;
        }

        $title = trans('projects::general.title');

        $event->menu->route('portal.projects.projects.index', $title, [], 45, ['icon' => 'science']);
    }
}
