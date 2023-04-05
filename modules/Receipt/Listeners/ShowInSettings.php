<?php

namespace Modules\Receipt\Listeners;

use App\Events\Menu\SettingsCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class ShowInSettings
{
    use Modules, Permissions;

    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (!$this->moduleIsEnabled('receipt')) {
            return;
        }

        $title = trim(trans('receipt::general.title'));

        if (!$this->canAccessMenuItem($title, 'read-receipt-settings')) {
            return;
        }

        $event->menu->route('receipt.setting', $title, [], 121, [
            'icon' => 'receipt',
            'search_keywords' => trans('custom-fields::general.description')
        ]);
    }
}
