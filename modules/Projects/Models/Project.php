<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;
use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use App\Traits\Media;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Projects\Casts\DateFormat;

class Project extends Model
{
    use Media;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    protected $dates = ['deleted_at', 'started_at', 'ended_at'];

    protected $fillable = ['company_id', 'name', 'description', 'customer_id', 'status', 'started_at', 'ended_at', 'billing_type', 'billing_rate'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'started_at' => DateFormat::class,
        'ended_at' => DateFormat::class,
    ];

    public function financials()
    {
        return $this->hasMany(Financial::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'Modules\Projects\Models\Financial', 'project_id', 'financialable_id')->where('financialable_type', Transaction::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'Modules\Projects\Models\Financial', 'project_id', 'financialable_id')->where('financialable_type', Document::class);
    }

    public function tasks()
    {
        return $this->hasMany('Modules\Projects\Models\Task', 'project_id');
    }

    public function discussions()
    {
        return $this->hasMany('Modules\Projects\Models\Discussion', 'project_id');
    }

    public function users()
    {
        return $this->hasMany('Modules\Projects\Models\ProjectUser', 'project_id');
    }

    public function activities()
    {
        return $this->hasMany('Modules\Projects\Models\Activity', 'project_id');
    }

    public function milestones()
    {
        return $this->hasMany('Modules\Projects\Models\Milestone', 'project_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Common\Contact');
    }

    public function timesheets()
    {
        return $this->hasMany('Modules\Projects\Models\ProjectTaskTimesheet', 'project_id');
    }

    /**
     * Get the project's status translated.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function transStatus(): Attribute
    {
        $status = "projects::general." . ($this->status ?: "draft");
        return Attribute::make(
            get:fn() => trans($status)
        );
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
                'title' => trans('general.show'),
                'icon' => 'visibility',
                'url' => route('projects.projects.show', $this->id),
                'permission' => 'read-projects-projects',
            ];

            $actions[] = [
                'title' => trans('general.edit'),
                'icon' => 'edit',
                'url' => route('projects.projects.edit', $this->id),
                'permission' => 'update-projects-projects',
            ];

            $actions[] = [
                'type' => 'delete',
                'icon' => 'delete',
                'route' => 'projects.projects.destroy',
                'permission' => 'delete-projects-projects',
                'model' => $this,
            ];
        } else {
            $actions[] = [
                'title' => trans('general.show'),
                'icon' => 'visibility',
                'url' => route('portal.projects.projects.show', $this->id),
                'permission' => 'read-projects-portal-projects',
            ];
        }

        return $actions;
    }

    /**
     * Get the status label.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'inprogress' => 'status-warning',
            'completed' => 'status-success',
            'canceled' => 'status-danger',
            default => 'status-draft',
        };
    }
}
