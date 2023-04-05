<?php

namespace Modules\Helpdesk\Observers;

use App\Abstracts\Observer;
use Modules\Helpdesk\Notifications\Ticket as Notification;
use Modules\Helpdesk\Models\Ticket as Model;
use Modules\Helpdesk\Models\Status;

class Ticket extends Observer
{
    /**
     * Listen to the created event.
     *
     * @param  Model $ticket
     *
     * @return void
     */
    public function created(Model $ticket)
    {
        // Do not send email if created from IMPORT
        if ($ticket->created_from == 'helpdesk::import')
            return;

        $user = $ticket->owner;

        try {
            $user->notify(new Notification($ticket, 'ticket_created'));

            // TODO: Add Helpdesk admin to receive an email when a ticket is created
        } catch (\Exception $e) {
            flash(trans('helpdesk::general.error.email_error'))->warning()->important();
        }
    }

    /**
     * Listen to the updated event.
     *
     * @param  Model $ticket
     *
     * @return void
     */
    public function updated(Model $ticket)
    {
        $originalTicket = $ticket->getOriginal();

        if ($ticket->status_id !== $originalTicket['status_id']) {
            $status = Status::all()->where('id', $ticket->status_id)->first();

            // Only in case the nofitication for a specific status is enabled.
            if ($status->notification) {
                $user = $ticket->owner;

                try {
                    $user->notify(new Notification($ticket, 'ticket_updated'));
                } catch (\Exception $e) {
                    flash(trans('helpdesk::general.error.email_error'))->warning()->important();
                }
            }
        }
    }
}
