<?php

namespace Modules\Projects\Listeners;

use App\Events\Menu\NewwCreated as Event;
use App\Traits\Permissions;

class AddToNewMenu
{
    use Permissions;

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $menu = $event->menu;

        $title = trim(trans_choice('projects::general.projects', 1));
        if ($this->canAccessMenuItem($title, 'create-projects-projects')) {
            $menu->route('projects.projects.create', $title, [], 80, ['icon' => 'science']);
        }
    }
}
