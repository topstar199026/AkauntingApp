<?php

namespace Modules\Projects\Jobs\Projects;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\ProjectUser;

class CreateProjectUser extends Job implements ShouldCreate
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() : ProjectUser
    {
        DB::transaction(function () {
            $this->model = ProjectUser::create($this->request->all());
        });

        return $this->model;
    }
}
