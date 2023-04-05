<?php

namespace Modules\Helpdesk\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldUpdate;
use Modules\Helpdesk\Models\Reply;

class UpdateReply extends Job implements ShouldUpdate
{
    /**
     * Execute the job.
     *
     * @return Reply
     */
    public function handle(): Reply
    {
        \DB::transaction(function () {
            $this->model->update($this->request->all());
        });

        return $this->model;
    }
}
