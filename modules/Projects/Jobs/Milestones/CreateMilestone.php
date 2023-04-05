<?php

namespace Modules\Projects\Jobs\Milestones;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\Milestone;

class CreateMilestone extends Job implements ShouldCreate
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model = Milestone::create($this->request->all());
        });

        return $this->model;
    }
}
