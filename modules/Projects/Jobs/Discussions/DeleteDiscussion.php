<?php

namespace Modules\Projects\Jobs\Discussions;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\ShouldDelete;
use Illuminate\Support\Facades\DB;

class DeleteDiscussion extends Job implements ShouldDelete, HasOwner
{
    /**
     * Execute the job.
     *
     * @return Task
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model->delete();
        });

        return true;
    }
}