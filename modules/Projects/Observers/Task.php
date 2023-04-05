<?php

namespace Modules\Projects\Observers;

use App\Abstracts\Observer;
use App\Traits\Jobs;
use Modules\Projects\Jobs\Activities\CreateActivity;
use Modules\Projects\Models\Task as Model;

class Task extends Observer
{
    use Jobs;

    /**
     * Listen to the created event.
     *
     * @param Model $task
     * @return void
     */
    public function created(Model $task)
    {
        $this->dispatch(new CreateActivity([
            'company_id' => company_id(),
            'project_id' => request('project_id'),
            'activity_id' => $task->id,
            'activity_type' => get_class($task),
            'description' => trans('projects::activities.created.task', [
                'user' => auth()->user()->name,
                'task' => $task->name
            ]),
            'created_by' => auth()->id()
        ]));
    }
}
