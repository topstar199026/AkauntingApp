<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;
use App\Traits\Media;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use Media;

    protected $table = 'project_tasks';

    protected $fillable = ['company_id', 'project_id', 'milestone_id', 'name', 'description', 'status', 'started_at', 'deadline_at', 'priority', 'billable', 'is_visible_to_customer', 'hourly_rate', 'created_by', 'is_invoiced', 'invoice_id'];

    public function milestone()
    {
        return $this->belongsTo('Modules\Projects\Models\Milestone');
    }

    public function project()
    {
        return $this->belongsTo('Modules\Projects\Models\Project');
    }

    public function users()
    {
        return $this->hasMany('Modules\Projects\Models\ProjectTaskUser', 'task_id');
    }

    public function timesheets()
    {
        return $this->hasMany('Modules\Projects\Models\ProjectTaskTimesheet', 'task_id');
    }

    public function scopeVisibleToCustomer(Builder $query)
    {
        return $query->where('is_visible_to_customer', true);
    }

    /**
     * Get the attachments.
     *
     * @return string
     */
    public function getAttachmentAttribute($value)
    {
        if (!empty($value) && !$this->hasMedia('attachment')) {
            return $value;
        } elseif (!$this->hasMedia('attachment')) {
            return false;
        }

        return $this->getMedia('attachment')->all();
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'not-started' => 'status-draft',
            'active' => 'status-partial',
            'completed' => 'status-success',
            default => 'status-draft',
        };
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        if (user()->isCustomer()) {
            return [
                [
                    'type' => 'button',
                    'title' => trans('general.show'),
                    'icon' => 'visibility',
                    'attributes' => [
                        '@click' => 'onModalAddNew("' . route('portal.projects.tasks.show', ['project' => $this->project->id, 'task' => $this->id]) . '")',
                    ],
                    'permission' => 'read-projects-portal-tasks',
                ]
            ];
        }

        $actions = [];

        $actions[] = [
            'type' => 'button',
            'title' => trans('general.show'),
            'icon' => 'visibility',
            'attributes' => [
                '@click' => 'onModalAddNew("' . route('projects.tasks.show', ['project' => $this->project->id, 'task' => $this->id]) . '")',
            ],
            'permission' => 'read-projects-tasks',
        ];

        $actions[] = [
            'type' => 'button',
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'attributes' => [
                '@click' => 'onModalAddNew("' . route('projects.tasks.edit', [$this->project->id, $this->id]) . '")',
            ],
            'permission' => 'update-projects-tasks',
        ];

        $actions[] = [
            'type' => 'delete',
            'icon' => 'delete',
            'title' => trans_choice('projects::general.tasks', 1),
            'route' => [
                'projects.tasks.destroy',
                $this->project->id,
                $this->id,
            ],
            'permission' => 'delete-projects-tasks',
            'model' => $this,
        ];

        if ($this->timesheets->isEmpty() || $this->timesheets->last()->ended_at !== null) {
            $actions[] = [
                'type' => 'button',
                'title' => trans('general.start'),
                'icon' => 'play_arrow',
                'attributes' => [
                    '@click' => 'timesheet("' . route('projects.timesheets.start', [$this->project, $this]) . '")',
                ],
                'permission' => 'update-projects-timesheets',
            ];
        } elseif ($this->timesheets->isNotEmpty()) {
            $actions[] = [
                'type' => 'button',
                'title' => trans('projects::general.stop'),
                'icon' => 'stop',
                'attributes' => [
                    '@click' => 'timesheet("' . route('projects.timesheets.stop', [$this->project, $this->timesheets()->whereNull('ended_at')->first()]) . '")',
                ],
                'permission' => 'update-projects-timesheets',
            ];
        }

        return $actions;
    }
}
