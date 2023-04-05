<?php

namespace Modules\Projects\Jobs\Milestones;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldUpdate;
use Illuminate\Support\Facades\DB;

class UpdateMilestone extends Job implements ShouldUpdate
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
