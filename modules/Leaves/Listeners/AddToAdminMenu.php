<?php

namespace Modules\Leaves\Listeners;

use App\Traits\Modules;
use Modules\Employees\Events\HRDropdownCreated as Event;

class AddToAdminMenu
{
    use Modules;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($this->moduleIsDisabled('leaves')) {
            return;
        }

        $user = user();

        if (!$user->canAny([
            'read-leaves-main',
            'read-leaves-entitlements',
            'read-leaves-calendar',
        ])) {
            return;
        }

        $event->menu->dropdown(trans('leaves::general.name'), function ($sub) use ($user) {
            if ($user->can('read-leaves-entitlements')) {
                $sub->route('leaves.entitlements.index', trans_choice('leaves::general.entitlements', 2), [], 10, []);
            }

            if ($user->can('read-leaves-calendar')) {
                $sub->route('leaves.calendar.index', trans('leaves::general.calendar'), [], 20, []);
            }
        }, 60, ['title' => trans('leaves::general.name')]);
    }
}
