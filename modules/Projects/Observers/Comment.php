<?php

namespace Modules\Projects\Observers;

use App\Abstracts\Observer;
use App\Traits\Jobs;
use Modules\Projects\Jobs\Activities\CreateActivity;
use Modules\Projects\Models\Comment as Model;

class Comment extends Observer
{
    use Jobs;

    /**
     * Listen to the created event.
     *
     * @param Model $comment
     * @return void
     */
    public function created(Model $comment)
    {
        $this->dispatch(new CreateActivity([
            'company_id' => company_id(),
            'project_id' => request('project_id'),
            'activity_id' => $comment->id,
            'activity_type' => get_class($comment),
            'description' => trans('projects::activities.created.comment', [
                'user' => auth()->user()->name,
                'discussion' => $comment->discussion->name
            ]),
            'created_by' => auth()->id()
        ]));
    }
}
