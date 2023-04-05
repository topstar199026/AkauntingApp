<?php

namespace Modules\Helpdesk\Jobs;

use App\Abstracts\Job;
use Modules\Helpdesk\Models\TicketDocument;

class DeleteTicketDocuments extends Job
{
    protected $ticket;

    /**
     * Create a new job instance.
     *
     * @param  $item
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;

        // Not required to call parent constructor since no Job interfaces have been implemented.
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): bool
    {
        \DB::transaction(function () {
            $models = TicketDocument::where('ticket_id', $this->ticket->id)->get();
            foreach($models as $model) {
                $model->delete();
            }
        });

        return true;
    }
}
