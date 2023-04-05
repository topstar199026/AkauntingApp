<?php

namespace Modules\Appointments\Listeners;

use App\Events\Menu\SettingsCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class AddToSettingsMenu
{
    use Permissions, Modules;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (! $this->moduleIsEnabled('appointments')) {
            return;
        }

        $title = trim(trans('appointments::general.name'));
        if ($this->canAccessMenuItem($title, 'read-appointments-settings')) {
            $event->menu->route('appointments.settings.edit', $title, [], 602, ['icon' => 'today', 'search_keywords' => trans('appointments::general.description')]);
        }
    }
}
