<?php

namespace Modules\Appointments\Models;

use App\Abstracts\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    protected $table = 'appointments_appointments';

    protected $fillable = [
        'company_id',
        'appointment_name',
        'appointment_duration',
        'before_schedule_appointment',
        'after_schedule_appointment',
        'allow_cancelled',
        'reminders',
        'recurring',
        'question_ids',
        'enabled',
        'approval_control',
        'appointment_type',
        'owner',
        'amount',
        'starting_time',
        'ending_time',
        'week_days'
    ];

    public function employees()
    {
        return $this->hasMany('Modules\Appointments\Models\Employee', 'appointment_id', 'id');
    }

    public function schedules()
    {
        return $this->hasMany('Modules\Appointments\Models\Scheduled', 'appointment_id', 'id');
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        // $actions[] = [
        //     'title' => trans('general.share'),
        //     'icon' => 'share',
        //     'url' => URL::signedRoute('signed.appointments.appointments.signed', [$this->id]),
        //     'permission' => 'create-appointments-appointments',
        // ];

        $actions[] = [
            'title' => trans('general.show'),
            'icon' => 'visibility',
            'url' => route('appointments.appointments.show', $this->id),
            'permission' => 'read-appointments-appointments',
        ];

        $actions[] = [
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'url' => route('appointments.appointments.edit', $this->id),
            'permission' => 'update-appointments-appointments',
        ];

        $actions[] = [
            'type' => 'delete',
            'title' => trans_choice('appointments::general.appointments', 1),
            'icon' => 'delete',
            'route' => 'appointments.appointments.destroy',
            'permission' => 'delete-appointments-appointments',
            'model' => $this,
        ];

        return $actions;
    }
}
