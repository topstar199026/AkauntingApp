<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;

class Milestone extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_milestones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['company_id', 'project_id', 'name', 'deadline_at', 'description'];

    public function tasks()
    {
        return $this->hasMany('Modules\Projects\Models\Task', 'milestone_id');
    }

    public function project()
    {
        return $this->belongsTo('Modules\Projects\Models\Project');
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
                '@click' => 'onModalAddNew("' . route('projects.milestones.edit', [$this->project->id, $this->id]) . '")',
            ],
            'permission' => 'update-projects-milestones',
        ];

        $actions[] = [
            'type' => 'delete',
            'icon' => 'delete',
            'title' => trans_choice('projects::general.milestones', 1),
            'route' => [
                'projects.milestones.destroy',
                $this->project->id,
                $this->id,
            ],
            'permission' => 'delete-projects-milestones',
            'model' => $this,
        ];

        return $actions;
    }
}
