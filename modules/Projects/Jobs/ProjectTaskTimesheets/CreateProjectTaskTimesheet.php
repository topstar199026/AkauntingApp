<?php

namespace Modules\Projects\Jobs\ProjectTaskTimesheets;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\ProjectTaskTimesheet;

class CreateProjectTaskTimesheet extends Job implements ShouldCreate
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model = ProjectTaskTimesheet::create($this->request->all());
        });

        return $this->model;
    }
}
