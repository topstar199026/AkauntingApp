<?php

namespace Modules\Projects\Jobs\ProjectTaskUsers;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Events\Tasks\MemberAssigned;
use Modules\Projects\Models\ProjectTaskUser;
use Modules\Projects\Notifications\Tasks\MemberAssignment as Notification;

class CreateProjectTaskUser extends Job implements ShouldCreate
{
    protected $project_task_user;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->project_task_user = ProjectTaskUser::create($this->request->all());

            $task = $this->project_task_user->task;

            $user = $this->project_task_user->user;

            event(new MemberAssigned($task, $user, Notification::class));
        });
    }
}
