<?php

namespace Modules\Calendar\Listeners;

use App\Events\Menu\SettingsCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class ShowInSettingsMenu
{
    use Modules, Permissions;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (!$this->moduleIsEnabled('calendar')) {
            return;
        }

        $title = trans('calendar::general.name');

        if ($this->canAccessMenuItem($title, 'read-calendar-settings')) {
            $event->menu->route('calendar.settings.edit', $title, [], 604, ['icon' => 'custom-calendar_month', 'search_keywords' => trans('calendar::general.description')]);
        }
    }
}
