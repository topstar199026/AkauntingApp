<?php

namespace Modules\Projects\Observers;

use App\Abstracts\Observer;
use App\Models\Auth\User as Model;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\ProjectTaskTimesheet;
use Modules\Projects\Models\ProjectTaskUser;
use Modules\Projects\Models\ProjectUser;

class User extends Observer
{
    /**
     * Listen to the deleted event.
     *
     * @param Model $user
     * @return void
     */
    public function deleted(Model $user)
    {
        DB::transaction(function () use ($user) {
            ProjectUser::where('user_id', $user->id)->delete();
            ProjectTaskUser::where('user_id', $user->id)->delete();
            ProjectTaskTimesheet::where('user_id', $user->id)->delete();
        });
    }
}
