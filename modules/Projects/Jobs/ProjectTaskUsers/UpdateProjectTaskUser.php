<?php

namespace Modules\Projects\Jobs\ProjectTaskUsers;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldUpdate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\ProjectTaskUser;

class UpdateProjectTaskUser extends Job implements ShouldUpdate
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): ProjectTaskUser
    {
        DB::transaction(function () {
            $this->model->update($this->request->all());
        });

        return $this->model;
    }
}
