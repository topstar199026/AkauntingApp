<?php

namespace Modules\Appointments\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $table = 'appointments_questions';

    protected $fillable = [
        'company_id',
        'question',
        'question_type',
        'required_answer',
        'enabled'
    ];

    public function answers()
    {
        return $this->hasMany('Modules\Appointments\Models\QuestionValue', 'question_id', 'id');
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        $actions[] = [
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'url' => route('appointments.questions.edit', $this->id),
            'permission' => 'update-appointments-questions',
        ];

        $actions[] = [
            'type' => 'delete',
            'title' => trans_choice('appointments::general.questions', 1),
            'icon' => 'delete',
            'route' => 'appointments.questions.destroy',
            'permission' => 'delete-appointments-questions',
            'model' => $this,
        ];

        return $actions;
    }
}
