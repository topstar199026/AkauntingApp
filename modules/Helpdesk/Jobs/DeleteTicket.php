<?php

namespace Modules\Helpdesk\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;

class DeleteTicket extends Job implements ShouldDelete
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): bool
    {
        if (count($this->model->document_ids)) {
            $this->dispatch(new DeleteTicketDocuments($this->model));
        }

        \DB::transaction(function () {
            $this->model->delete();
        });


        return true;
    }
}
