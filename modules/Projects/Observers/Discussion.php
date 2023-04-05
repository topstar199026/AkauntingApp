<?php

namespace Modules\Projects\Observers;

use App\Abstracts\Observer;
use App\Traits\Jobs;
use Modules\Projects\Jobs\Activities\CreateActivity;
use Modules\Projects\Models\Discussion as Model;

class Discussion extends Observer
{
    use Jobs;

    /**
     * Listen to the created event.
     *
     * @param Model $discussion
     * @return void
     */
    public function created(Model $discussion)
    {
        $this->dispatch(new CreateActivity([
            'company_id' => company_id(),
            'project_id' => $discussion->project_id,
            'activity_id' => $discussion->id,
            'activity_type' => get_class($discussion),
            'description' => trans('projects::activities.created.discussion', [
                'user' => auth()->user()->name,
                'discussion' => $discussion->name
            ]),
            'created_by' => auth()->id()
        ]));
    }
}
