<?php

namespace Modules\Appointments\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Scheduled extends Model
{
    use Notifiable;

    protected $table = 'appointments_scheduled';

    protected $fillable = [
        'company_id',
        'appointment_id',
        'document_id',
        'contact_id',
        'employee_id',
        'name',
        'email',
        'phone',
        'question_answer',
        'starting_time',
        'ending_time',
        'status',
        'date'
    ];

    public function appointment()
    {
        return $this->belongsTo('Modules\Appointments\Models\Appointment');
    }

    public function contact()
    {
        return $this->belongsTo('App\Models\Common\Contact')->withDefault(['name' => trans('general.na')]);
    }

    public function employee()
    {
        return $this->belongsTo('Modules\Employees\Models\Employee');
    }

    public function getStatusLabelAttribute(): string
    {
        switch ($this->status) {
            case 'sent':
                $status_label = 'status-sent';
                break;
            case 'waiting':
                $status_label = 'status-viewed';
                break;
            case 'approve':
                $status_label = 'status-success';
                break;
            case 'dismiss':
                $status_label = 'status-canceled';
                break;
        }

        return $status_label;
    }

        /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        if ($this->appointment->appointment_type == 'paid' && $this->status != 'approve' && $this->status != 'sent') {
            $actions[] = [
                'title' => trans('general.send'),
                'icon' => 'send',
                'url' => route('appointments.scheduled.sent', $this->id),
                'permission' => 'create-appointments-appointments',
            ];
        } else if ($this->status != 'approve' ) {
            $actions[] = [
                'title' => trans('appointments::general.approve'),
                'icon' => 'done',
                'url' => route('appointments.scheduled.approve', $this->id),
                'permission' => 'create-appointments-appointments',
            ];
        } else {
            $actions[] = [
                'title' => trans('appointments::general.dismiss'),
                'icon' => 'close',
                'url' => route('appointments.scheduled.dismiss', $this->id),
                'permission' => 'create-appointments-appointments',
            ];
        }

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
