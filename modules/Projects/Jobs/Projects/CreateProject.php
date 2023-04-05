<?php

namespace Modules\Projects\Jobs\Projects;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldCreate;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\Project;

class CreateProject extends Job implements ShouldCreate
{
    public function handle(): Project
    {
        DB::transaction(function () {
            $this->model = Project::create($this->request->all());

            // Update billing rate
            if ($this->model->billing_type == 'fixed-rate') {
                $this->model->billing_rate = $this->request->get('total_rate');
            }

            if ($this->model->billing_type == 'projects-hours') {
                $this->model->billing_rate = $this->request->get('rate_per_hour');
            }

            $this->model->save();

            // Create members of the project
            $members = $this->request->get('members');

            $arguments = [
                'company_id' => company_id(),
                'project_id' => $this->model->id,
            ];

            foreach ($members as $member) {
                $arguments['user_id'] = $member;

                $this->dispatch(new CreateProjectUser($arguments));
            }

            $user = user();

            if (!in_array($user->id, $members)) {
                $arguments['user_id'] = $user->id;

                $this->dispatch(new CreateProjectUser($arguments));
            }

            if ($this->request->attachment) {
                foreach ($this->request->attachment as $attachment) {
                    $media = $this->getMedia($attachment, "projects/{$this->model->id}");

                    $this->model->attachMedia($media, 'attachment');
                }
            }
        });

        return $this->model;
    }
}
