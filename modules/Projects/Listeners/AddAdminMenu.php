<?php

namespace Modules\Projects\Listeners;

use App\Events\Menu\AdminCreated as Event;
use App\Traits\Modules;

class AddAdminMenu
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

        if (user()->cannot('read-projects-projects')) {
            return;
        }

        $title = trans('projects::general.title');

        $event->menu->route('projects.projects.index', $title, [], 21, ['icon' => 'science']);
    }
}
