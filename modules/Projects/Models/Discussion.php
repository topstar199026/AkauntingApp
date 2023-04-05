<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;

class Discussion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_discussions';
    
    protected $fillable = ['company_id', 'subject', 'description', 'project_id', 'created_by'];

    public function project()
    {
        return $this->belongsTo('Modules\Projects\Models\Project');
    }

    public function comments()
    {
        return $this->hasMany('Modules\Projects\Models\Comment', 'discussion_id');
    }

    public function likes()
    {
        return $this->hasMany('Modules\Projects\Models\DiscussionLike', 'discussion_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User', 'created_by');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeSort($query, $field, $order)
    {
        return $query->orderBy($field, $order);
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        if (! user()->isCustomer()) {
            $actions[] = [
                'type' => 'button',
                'title' => trans('general.show'),
                'icon' => 'visibility',
                'attributes' => [
                    '@click' => 'onModalAddNew("' . route('projects.discussions.show', [$this->project->id, $this->id]) . '")',
                ],
                'permission' => 'read-projects-discussions',
            ];
    
            $actions[] = [
                'type' => 'button',
                'title' => trans('general.edit'),
                'icon' => 'edit',
                'attributes' => [
                    '@click' => 'onModalAddNew("' . route('projects.discussions.edit', [$this->project->id, $this->id]) . '")',
                ],
                'permission' => 'update-projects-discussions',
            ];
    
            $actions[] = [
                'type' => 'delete',
                'icon' => 'delete',
                'title' => trans_choice('projects::general.discussions', 1),
                'route' => [
                    'projects.discussions.destroy',
                    $this->project->id,
                    $this->id,
                ],
                'permission' => 'delete-projects-discussions',
                'model' => $this,
            ];
        } else {
            $actions[] = [
                'type' => 'button',
                'title' => trans('general.show'),
                'icon' => 'visibility',
                'attributes' => [
                    '@click' => 'onModalAddNew("' . route('portal.projects.discussions.show', [$this->project->id, $this->id]) . '")',
                ],
                'permission' => 'read-projects-portal-discussions',
            ];
        }

        return $actions;
    }
}
