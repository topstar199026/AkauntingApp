<?php

namespace Modules\Helpdesk\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use Modules\Helpdesk\Models\Ticket;

class CreateTicket extends Job implements HasOwner, HasSource, ShouldCreate
{
    /**
     * Execute the job.
     *
     * @return Ticket
     */
    public function handle(): Ticket
    {
        \DB::transaction(function () {
            $this->model = Ticket::create($this->request->all());

            // Upload attachment
            if ($this->request->file('attachment')) {
                foreach ($this->request->file('attachment') as $attachment) {
                    $media = $this->getMedia($attachment, 'helpdesk');

                    $this->model->attachMedia($media, 'attachment');
                }
            }

            if (!empty($this->request['document_ids'])) {
                $this->dispatch(new CreateTicketDocuments($this->model, $this->request));
            }
        });

        return $this->model;
    }
}
