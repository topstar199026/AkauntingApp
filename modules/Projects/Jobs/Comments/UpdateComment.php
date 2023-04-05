<?php

namespace Modules\Projects\Jobs\Comments;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\ShouldUpdate;
use Illuminate\Support\Facades\DB;

class UpdateComment extends Job implements ShouldUpdate, HasOwner
{
    /**
     * Execute the job.
     *
     * @return Task
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model->update($this->request->all());
        });

        return $this->model;
    }
}