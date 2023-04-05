<?php

namespace Modules\Projects\Jobs\ProjectTaskUsers;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;
use Illuminate\Support\Facades\DB;

class DeleteProjectTaskUser extends Job implements ShouldDelete
{
    protected $model;

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
