<?php

namespace Modules\Projects\Jobs\Projects;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldUpdate;
use App\Models\Common\Media;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\ProjectUser;
use Modules\Projects\Jobs\Projects\DeleteProjectUser;

class UpdateProject extends Job implements ShouldUpdate
{
    public function handle(): Project
    {
        DB::transaction(function () {
            $this->model->update($this->request->all());

            // Update billing rate
            if ($this->model->billing_type == 'fixed-rate') {
                $this->model->billing_rate = $this->request->get('total_rate');
            }

            if ($this->model->billing_type == 'projects-hours') {
                $this->model->billing_rate = $this->request->get('rate_per_hour');
            }

            $this->model->save();

            // Update members of the project
            $all_members = ProjectUser::where('project_id', $this->model->id)
                ->get()
                ->pluck('user_id')
                ->toArray();

            $members = $this->request->get('members');

            $arguments = [
                'company_id' => company_id(),
                'project_id' => $this->model->id,
            ];

            foreach ($all_members as $member) {
                if (!in_array($member, $members)) {
                    $arguments['user_id'] = $member;

                    $this->dispatch(new DeleteProjectUser($arguments));
                }
            }

            foreach ($members as $new_member) {
                if (!in_array($new_member, $all_members)) {
                    $arguments['user_id'] = $new_member;

                    $this->dispatch(new CreateProjectUser($arguments));
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
                    $media = $this->getMedia($attachment, "projects/{$this->model->id}");

                    $this->model->attachMedia($media, 'attachment');
                }
            } elseif (! $this->request->attachment && $this->model->attachment) {
                $this->deleteMediaModel($this->model, 'attachment', $this->request);
            }
        });

        return $this->model;
    }
}
