<?php

namespace Modules\Projects\Listeners;

use App\Events\Auth\UserDeleting as Event;
use Modules\Projects\Models\Comment;
use Modules\Projects\Models\ProjectTaskUser;
use Modules\Projects\Models\ProjectUser;

class PreventUserDeleting
{
    public function handle(Event $event)
    {
        $user = $event->user;

        $condition = ProjectUser::where('user_id', $user->id)->exists()
                    || ProjectTaskUser::where('user_id', $user->id)->exists()
                    || Comment::where('created_by', $user->id)->exists();

        if ($condition) {
            throw new \Exception(trans('projects::messages.error.prevent_user_delete'));
        }
    }
}
