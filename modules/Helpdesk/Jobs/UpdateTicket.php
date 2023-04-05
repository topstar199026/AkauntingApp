<?php

namespace Modules\Helpdesk\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldUpdate;
use Modules\Helpdesk\Models\Ticket;

class UpdateTicket extends Job implements ShouldUpdate
{
    /**
     * Execute the job.
     *
     * @return Ticket
     */
    public function handle(): Ticket
    {
        \DB::transaction(function () {
            $this->model->update($this->request->all());

            // If only one property is updated skip the rest of the update
            if (count($this->request->toArray()) > 1) {
                // Upload attachment
                if ($this->request->file('attachment')) {
                    $this->deleteMediaModel($this->model, 'attachment', $this->request);

                    foreach ($this->request->file('attachment') as $attachment) {
                        $media = $this->getMedia($attachment, 'helpdesk');

                        $this->model->attachMedia($media, 'attachment');
                    }
                } elseif ($this->model->attachment) {
                    $this->deleteMediaModel($this->model, 'attachment', $this->request);
                }

                // Linked documents
                $this->deleteRelationships($this->model, ['documents']);
                if (!empty($this->request['document_ids'])) {
                    $this->dispatch(new CreateTicketDocuments($this->model, $this->request));
                }
            }
        });

        return $this->model;
    }
}
