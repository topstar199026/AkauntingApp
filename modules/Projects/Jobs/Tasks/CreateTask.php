<?php

namespace Modules\Projects\Jobs\Tasks;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Jobs\ProjectTaskUsers\CreateProjectTaskUser;
use Modules\Projects\Models\Task;

class CreateTask extends Job implements ShouldCreate, HasOwner
{
    /**
     * Execute the job.
     *
     * @return Task
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->model = Task::create($this->request->all());

            $users = $this->request->input('users', [user()->id]);

            foreach ($users as $user) {
                $request = [
                    'company_id' => company_id(),
                    'project_id' => $this->model->project_id,
                    'milestone_id' => $this->model->milestone_id,
                    'task_id' => $this->model->id,
                    'user_id' => $user,
                ];

                $this->dispatch(new CreateProjectTaskUser($request));
            }

            if ($this->request->attachment) {
                foreach ($this->request->attachment as $attachment) {
                    $media = $this->getMedia($attachment, "projects/{$this->model->project_id}/tasks/{$this->model->id}");

                    $this->model->attachMedia($media, 'attachment');
                }
            }
        });

        return $this->model;
    }
}
