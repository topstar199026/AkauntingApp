<?php

namespace Modules\Helpdesk\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldCreate;
use Modules\Helpdesk\Models\TicketDocument;

class CreateTicketDocuments extends Job implements ShouldCreate
{
    protected $ticket;

    /**
     * Create a new job instance.
     *
     * @param  $item
     * @param  $request
     */
    public function __construct($ticket, $request)
    {
        $this->ticket = $ticket;

        parent::__construct($request);
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle(): TicketDocument
    {
        \DB::transaction(function () {
            foreach ($this->request['document_ids'] as $document_id) {
                $this->model = TicketDocument::create([
                    'company_id' => $this->ticket->company_id,
                    'ticket_id' => $this->ticket->id,
                    'document_id' => $document_id,
                ]);
            }
        });

        return $this->model;
    }
}
