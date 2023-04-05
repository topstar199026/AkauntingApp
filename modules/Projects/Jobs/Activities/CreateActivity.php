<?php

namespace Modules\Projects\Jobs\Activities;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\Activity;

class CreateActivity extends Job implements ShouldCreate
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model = Activity::create($this->request->all());
        });

        return $this->model;
    }
}
