<?php

namespace Modules\Leaves\Listeners;

use App\Events\Menu\SettingsCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class ShowInSettingsMenu
{
    use Modules, Permissions;

    public function handle(Event $event)
    {
        if ($this->moduleIsDisabled('leaves')) {
            return;
        }

        $title = trans('leaves::general.name');

        if ($this->canAccessMenuItem($title, 'read-leaves-settings')) {
            $event->menu->route('leaves.settings.edit', $title, [], 100, ['icon' => 'luggage', 'search_keywords' => trans('leaves::general.description')]);
        }
    }
}
