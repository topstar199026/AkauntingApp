<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;

class Activity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_activities';

    protected $fillable = ['company_id', 'project_id', 'activity_id', 'activity_type', 'description', 'created_by'];

    public function user()
    {
        return $this->hasOne('App\Models\Auth\User', 'id', 'created_by');
    }

    public function activity()
    {
        return $this->morphTo()->withTrashed();
    }

    public function getIcon()
    {
        return match ($this->activity_type) {
            'App\\Models\\Document\\Document'               => 'description',
            'App\\Models\\Banking\\Transaction'             => 'request_quote',
            'Modules\\Projects\\Models\\Task'               => 'checklist',
            'Modules\\Projects\\Models\\Milestone'          => 'check_circle',
            'Modules\\Projects\\Models\\Discussion'         => 'chat_bubble_outline',
            'Modules\\Projects\\Models\\Comment'            => 'textsms',
            'Modules\\Projects\\Models\\Project'            => 'account_tree',
            default                                         => 'question_mark',
        };
    }
}
