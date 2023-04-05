<?php

namespace Modules\Projects\Observers;

use App\Abstracts\Observer;
use App\Traits\Jobs;
use Modules\Projects\Jobs\Activities\CreateActivity;
use Modules\Projects\Models\Milestone as Model;

class Milestone extends Observer
{
    use Jobs;

    /**
     * Listen to the created event.
     *
     * @param Model $milestone
     * @return void
     */
    public function created(Model $milestone)
    {
        $this->dispatch(new CreateActivity([
            'company_id' => company_id(),
            'project_id' => request('project_id'),
            'activity_id' => $milestone->id,
            'activity_type' => get_class($milestone),
            'description' => trans('projects::activities.created.milestone', [
                'user' => auth()->user()->name,
                'milestone' => $milestone->name
            ]),
            'created_by' => auth()->id()
        ]));
    }
}
