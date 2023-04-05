<?php

namespace Modules\Projects\Jobs\Tasks;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldUpdate;
use App\Models\Common\Media;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\ProjectTaskUser;
use Modules\Projects\Jobs\ProjectTaskUsers\CreateProjectTaskUser;
use Modules\Projects\Jobs\ProjectTaskUsers\DeleteProjectTaskUser;
use Modules\Projects\Jobs\ProjectTaskUsers\UpdateProjectTaskUser;

class UpdateTask extends Job implements ShouldUpdate
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

            // Project task users part
            $users = ProjectTaskUser::where([
                'project_id' => $this->request->project_id,
                'milestone_id' => $this->request->milestone_id,
                'task_id' => $this->model->id,
            ])->get();

            $request = [
                'company_id' => company_id(),
                'project_id' => $this->model->project_id,
                'milestone_id' => $this->model->milestone_id,
                'task_id' => $this->model->id,
            ];

            $input_users = $this->request->input('users') ?? [];

            foreach ($users as $user) {
                if (in_array($user->user_id, $input_users)) {
                    $request['user_id'] = $user->user_id;

                    $this->dispatch(new UpdateProjectTaskUser($user, $request));
                } else {
                    $this->dispatch(new DeleteProjectTaskUser($user));
                }
            }

            foreach ($input_users as $user) {
                if ($users->doesntContain('user_id', $user)) {
                    $request['user_id'] = $user;

                    $this->dispatch(new CreateProjectTaskUser($request));
                }
            }

            // Upload attachment
            if ($this->request->attachment) {
                if ($this->model->attachment) {
                    $this->deleteMediaModel($this->model, 'attachment', $this->request);
                }

                foreach ($this->request->attachment as $value) {
                    if (is_array($value)) {
                        Media::withTrashed()->find($value['id'])->restore();
                    }
                }

                foreach ($this->request->file('attachment') as $attachment) {
                    $media = $this->getMedia($attachment, "projects/{$this->model->project_id}/tasks/{$this->model->id}");

                    $this->model->attachMedia($media, 'attachment');
                }
            } elseif (! $this->request->attachment && $this->model->attachment) {
                $this->deleteMediaModel($this->model, 'attachment', $this->request);
            }
        });

        return $this->model;
    }
}
