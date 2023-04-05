<?php

namespace Modules\Projects\Jobs\Milestones;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;
use Illuminate\Support\Facades\DB;

class DeleteMilestone extends Job implements ShouldDelete
{
    /**
     * Execute the job.
     *
     * @return boolean|Exception
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model->delete();
        });

        return true;
    }
}
