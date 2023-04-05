<?php

namespace Modules\Projects\Jobs\Projects;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;
use Illuminate\Support\Facades\DB;

class DeleteProjectUser extends Job implements ShouldDelete
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): bool
    {
        DB::transaction(function () {
            $this->model->delete();
        });

        return true;
    }
}
