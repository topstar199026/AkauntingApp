<?php

namespace Modules\Projects\Jobs\ProjectTaskTimesheets;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;
use Illuminate\Support\Facades\DB;

class DeleteProjectTaskTimesheet extends Job implements ShouldDelete
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
