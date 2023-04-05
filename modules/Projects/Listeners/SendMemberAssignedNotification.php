<?php

namespace Modules\Projects\Listeners;

use Modules\Projects\Events\Tasks\MemberAssigned as Event;

class SendMemberAssignedNotification
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $task = $event->task;
        $user = $event->user;
        $notification = $event->notification;

        // Notify the user
        if ($user && !empty($user->email)) {
            $user->notify(new $notification($task, $user, "projects_task_assignment_member"));
        }
    }
}
