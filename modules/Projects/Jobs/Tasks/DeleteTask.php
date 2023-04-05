<?php

namespace Modules\Projects\Jobs\Tasks;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;
use Illuminate\Support\Facades\DB;

class DeleteTask extends Job implements ShouldDelete
{
    /**
     * Execute the job.
     *
     * @return boolean|Exception
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->deleteRelationships($this->model, ['users', 'timesheets']);

            $this->model->delete();
        });

        return true;
    }
}
