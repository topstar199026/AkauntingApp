<?php

namespace Modules\Appointments\Http\Requests;

use App\Abstracts\Http\FormRequest as Request;

class Appointment extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $amount = $time = $week_days = 'nullable';

        if ($this->request->get('appointment_type') == 'paid') {
            $amount = 'required|amount';
        }

        if ($this->request->get('owner') == 'admin') {
            $time = 'required|date_format:H:i';
            $week_days = 'required';
        }

        return [
            'appointment_name'              => 'required|string',
            'appointment_type'              => 'required|string',
            'amount'                        => $amount,
            'owner'                         => 'required|string',
            'starting_time'                 => $time,
            'ending_time'                   => $time,
            'week_days'                     => $week_days,
            'question_ids'                  => 'nullable',
            'appointment_duration'          => 'required|string',
            'reminders'                     => 'required|string',
            'before_schedule_appointment'   => 'required|string',
            'after_schedule_appointment'    => 'required|string',
            'allow_cancelled'               => 'required|string',
            'enabled'                       => 'integer|boolean',
        ];
    }
}
