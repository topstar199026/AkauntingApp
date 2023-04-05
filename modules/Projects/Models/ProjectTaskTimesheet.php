<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;
use App\Traits\DateTime;
use App\Utilities\Date;

class ProjectTaskTimesheet extends Model
{
    use DateTime;

    protected $fillable = ['company_id', 'project_id', 'task_id', 'user_id', 'started_at', 'ended_at', 'note'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['elapsed_time'];

    public function project()
    {
        return $this->belongsTo('Modules\Projects\Models\Project');
    }

    public function task()
    {
        return $this->belongsTo('Modules\Projects\Models\Task');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }

    /**
     * Get the elapsed time for the timesheet.
     *
     * @return string
     */
    public function getElapsedTimeAttribute()
    {
        $start = Date::parse($this->started_at);
        $end = Date::parse($this->ended_at);

        $days = $start->diffInDays($end);
        $hours = $start->copy()->addDays($days)->diffInHours($end);
        $minutes = $start->copy()->addDays($days)->addHours($hours)->diffInMinutes($end);

        return trans('projects::timesheets.elapsed_time', compact('days', 'hours', 'minutes'));
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        if (user()->isCustomer()) {
            return [];
        }

        $actions = [];

        $actions[] = [
            'type' => 'button',
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'attributes' => [
                '@click' => 'onModalAddNew("' . route('projects.timesheets.edit', [$this->project->id, $this->id]) . '")',
            ],
            'permission' => 'update-projects-timesheets',
        ];

        $actions[] = [
            'type' => 'delete',
            'icon' => 'delete',
            'title' => trans_choice('projects::general.timesheets', 1),
            'route' => [
                'projects.timesheets.destroy',
                $this->project->id,
                $this->id,
            ],
            'permission' => 'delete-projects-timesheets',
            'model' => $this,
        ];

        return $actions;
    }
}
