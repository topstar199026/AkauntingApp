<?php

namespace Modules\Appointments\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $table = 'appointments_employees';

    protected $fillable = [
        'company_id',
        'appointment_id',
        'contact_id',
        'employee_id',
        'week_days',
        'starting_time',
        'ending_time'
    ];

    public function employee()
    {
        return $this->belongsTo('Modules\Employees\Models\Employee');
    }
}
