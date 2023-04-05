<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;

class ProjectTaskUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_task_users';

    protected $fillable = ['company_id', 'project_id', 'milestone_id', 'task_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User', 'user_id');
    }

    public function task()
    {
        return $this->belongsTo('Modules\Projects\Models\Task', 'task_id');
    }

}
