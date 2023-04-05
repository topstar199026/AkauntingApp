<?php

namespace Modules\Appointments\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionValue extends Model
{
    protected $table = 'appointments_questions_values';

    protected $fillable = [
        'company_id',
        'question_id',
        'avaible_answer',
    ];
}
