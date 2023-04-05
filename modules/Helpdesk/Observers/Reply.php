<?php

namespace Modules\Helpdesk\Observers;

use App\Abstracts\Observer;
use Modules\Helpdesk\Notifications\Reply as Notification;
use Modules\Helpdesk\Models\Reply as Model;
use Modules\Helpdesk\Models\Ticket;

class Reply extends Observer
{
    /**
     * Listen to the created event.
     *
     * @param  Model $reply
     *
     * @return void
     */
    public function created(Model $reply)
    {
        $users = [];
        $ticket = Ticket::where('id', $reply->ticket_id)->first();

        // Send notification to ticket owner if the reply is not written by him/her and not internal
        // Skip in case owner is null (theoretically it should not happen, but we add the condition just in case)
        if (isset($ticket->owner->id) && ($ticket->owner->id !== $reply->owner->id) && !$reply->internal) {
            $users[] = $ticket->owner;
        }

        // Send notification to assignee if the reply is neither written by him/her nor the ticket owner and assignee are the same
        // Skip in case assignee is still not defined (null)
        if (isset($ticket->assignee_id) && ($ticket->assignee_id !== $reply->owner->id) && ($ticket->assignee_id !== $ticket->owner->id)) {
            $users[] = $ticket->assignee;
        }

        if (!empty($users)) {
            foreach ($users as $user) {
                try {
                    $user->notify(new Notification($reply, 'reply_created'));
                } catch (\Exception $e) {
                    flash(trans('helpdesk::general.error.email_error'))->warning()->important();
                }
            }
        }
    }
}
