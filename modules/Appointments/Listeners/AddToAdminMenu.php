<?php

namespace Modules\Appointments\Listeners;

use App\Events\Menu\AdminCreated as Event;
use App\Traits\Modules;
use App\Traits\Permissions;

class AddToAdminMenu
{
    use Permissions, Modules;

    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ( !$this->moduleIsEnabled('appointments')) {
            return;
        }

        $title = trim(trans('appointments::general.name'));

        if ($this->canAccessMenuItem($title, [
                'read-appointments-appointments',
                'read-appointments-questions',
                'read-appointments-scheduled',
            ])) {
            $event->menu->dropdown($title, function ($sub) {
                $title = trim(trans('appointments::general.name'));
                if ($this->canAccessMenuItem($title, 'read-appointments-appointments')) {
                    $sub->route('appointments.appointments.index', $title, [], 10, []);
                }

                $title = trim(trans_choice('appointments::general.questions', 2));
                if ($this->canAccessMenuItem($title, 'read-appointments-questions')) {
                    $sub->route('appointments.questions.index', $title, [], 20, []);
                }

                $title = trim(trans_choice('appointments::general.scheduled', 2));
                if ($this->canAccessMenuItem($title, 'read-appointments-scheduled')) {
                    $sub->route('appointments.scheduled.index', $title, [], 30, []);
                }
            }, 42, [
                'title' => $title,
                'icon' => 'today',
            ]);
        }
    }
}
