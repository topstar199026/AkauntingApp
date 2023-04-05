<?php

namespace Modules\Projects\Jobs\Projects;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;
use Illuminate\Support\Facades\DB;

class DeleteProject extends Job implements ShouldDelete
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): bool
    {
        DB::transaction(function () {
            $this->model->tasks()->each(function ($task) {
                $task->users()->delete();
            });

            $this->model->discussions()->each(function ($discussion) {
                $discussion->comments()
                    ->delete();
                $discussion->likes()
                    ->delete();
            });

            $this->deleteRelationships($this->model, [
                'tasks',
                'discussions',
                'users',
                'activities',
                'milestones',
                'timesheets',
                'financials'
            ]);

            $this->model->delete();
        });

        return true;
    }
}
