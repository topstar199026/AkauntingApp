<?php

namespace Modules\Calendar\Listeners;

use Auth;
use App\Events\Menu\AdminCreated as Event;
use App\Traits\Modules;

class AddToAdminMenu
{
    use Modules;

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (!$this->moduleIsEnabled('calendar')) {
            return;
        }

        // Add new item
        if (user()->can('read-calendar-calendar')) {
            $event->menu->route('calendar.index', trans('calendar::general.name'), [], 51, ['icon' => 'custom-calendar_month']);
        }
    }
}
