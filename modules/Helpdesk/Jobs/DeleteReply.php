<?php

namespace Modules\Helpdesk\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;

class DeleteReply extends Job implements ShouldDelete
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): bool
    {
        \DB::transaction(function () {
            $this->model->delete();
        });

        return true;
    }
}
