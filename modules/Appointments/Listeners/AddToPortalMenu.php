<?php

namespace Modules\Appointments\Listeners;

use App\Events\Menu\PortalCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class AddToPortalMenu
{
    use Permissions, Modules;

    /**
     * Handle the event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        if ( !$this->moduleIsEnabled('appointments')) {
            return;
        }

        $title = trim(trans('appointments::general.name'));

        if ($this->canAccessMenuItem($title, [
                'read-appointments-portal-appointments',
                'read-appointments-portal-scheduled',
            ])) {
            $event->menu->dropdown($title, function ($sub) {
                $title = trim(trans('appointments::general.name'));
                if ($this->canAccessMenuItem($title, 'read-appointments-portal-appointments')) {
                    $sub->route('portal.appointments.appointments.index', $title, [], 10, []);
                }

                $title = trim(trans_choice('appointments::general.scheduled', 2));
                if ($this->canAccessMenuItem($title, 'read-appointments-portal-scheduled')) {
                    $sub->route('portal.appointments.scheduled.index', $title, [], 20, []);
                }
            }, 42, [
                'title' => $title,
                'icon' => 'today',
            ]);
        }
    }
}
