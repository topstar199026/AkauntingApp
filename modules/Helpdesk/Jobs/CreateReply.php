<?php

namespace Modules\Helpdesk\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use Modules\Helpdesk\Models\Reply;

class CreateReply extends Job implements HasOwner, HasSource, ShouldCreate
{
    /**
     * Execute the job.
     *
     * @return Reply
     */
    public function handle(): Reply
    {
        \DB::transaction(function () {
            $this->model = Reply::create($this->request->all());
        });

        return $this->model;
    }
}
