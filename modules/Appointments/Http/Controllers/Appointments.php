<?php

namespace Modules\Appointments\Http\Controllers;

use Date;
use App\Models\Common\Contact;
use App\Models\Setting\Currency;
use App\Abstracts\Http\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Appointments\Models\Question;
use Modules\Appointments\Models\Scheduled;
use Modules\Appointments\Models\Appointment;
use Modules\Appointments\Jobs\Appointment\CreateAppointment;
use Modules\Appointments\Jobs\Appointment\DeleteAppointment;
use Modules\Appointments\Jobs\Appointment\UpdateAppointment;
use Modules\Appointments\Http\Requests\Appointment as Request;

class Appointments extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $appointments = Appointment::collect();

        return $this->response('appointments::appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $questions = Question::pluck('question', 'id');
        $employees = Contact::where('type', 'employee')->enabled()->pluck('name', 'id');

        $reminders = [
            '15 Minutes', '30 Minutes', '1 Hours',
            '3 Hours', '6 Hours', '1 Days'
        ];

        $week_days = [
            'sunday' => trans('appointments::general.days.sunday'),
            'monday' => trans('appointments::general.days.monday'),
            'tuesday' => trans('appointments::general.days.tuesday'),
            'wednesday' => trans('appointments::general.days.wednesday'),
            'thursday' => trans('appointments::general.days.thursday'),
            'friday' => trans('appointments::general.days.friday'),
            'saturday' => trans('appointments::general.days.saturday'),
        ];

        $recurring = [
            'weekly' => trans('appointments::general.recurring.weekly'),
            'monthly' => trans('appointments::general.recurring.monthly'),
            'yearly' => trans('appointments::general.recurring.yearly'),
        ];

        $appointment_type = [
            'free' => trans('appointments::general.free'),
            'paid' => trans('appointments::general.paid'),
        ];

        $owner = [
            'admin'   => trans('appointments::general.admin'),
            'employee' => trans('appointments::general.employee'),
        ];

        $currency = Currency::where('code', '=', setting('default.currency'))->first();

        return view('appointments::appointments.create', compact('owner', 'appointment_type', 'currency', 'reminders', 'recurring', 'week_days', 'questions', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateAppointment($request));

        if ($response['success']) {
            $response['redirect'] = route('appointments.appointments.index');

            $message = trans('messages.success.added', ['type' => trans_choice('appointments::general.name', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('appointments.appointments.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @param  Appointment  $appointment
     *
     * @return Response
     */
    public function show(Appointment $appointment)
    {
        $values = $question_type_select = $question_type_text = $events = $timestamp = [];
        $question_ids = json_decode($appointment->question_ids);

        if (!empty($question_ids)) {
            foreach ($question_ids as $key => $question_id) {
                $question = Question::find($question_id);

                if ($question->question_type == 0) {
                    $question_type_text[] = $question->question;
                } else {
                    $question_type_select[] = $question->question;

                    foreach ($question->answers as $question_value) {
                        $values[] = $question_value->avaible_answer;
                    }
                }
            }
        }

        if ($appointment->owner == 'admin') {
            $days = json_decode($appointment->week_days);

            foreach ($days as $day) {
                $date = Date::parse($day)->format('Y-m-d');

                $starting_time = strtotime($appointment->starting_time);
                $ending_time = strtotime($appointment->ending_time);

                $duration_time = explode(':', $appointment->appointment_duration);

                foreach ($duration_time as $time_key => $time) {
                    if ((int)$time < 10) {
                        $duration_time[$time_key] =  str_replace('0', '', $time);
                    }
                }

                $timestamp[$day][] = $appointment->starting_time;

                for ($i = $appointment->starting_time; $i < $appointment->ending_time;){
                    foreach ($duration_time as $key => $time) {
                        if ($time == '') {
                            $duration_time[$key] = 0;
                        }
                    }

                    $today = Date::today()->toDateString();
                    $day_control = date('Y-m-d', strtotime($i. '+' . $duration_time[0] . 'hour' . $duration_time[1] .'minute'));

                    if ($today == $day_control) {
                        $rand_time = date('H:i', strtotime($i. '+' . $duration_time[0] . 'hour' . $duration_time[1] .'minute'));
                        $timestamp[$day][] = $rand_time;
                        $i = $rand_time;
                    } else {
                        break;
                    }
                }
            }

            if ($appointment->recurring == 'monthly') {
                $recurring = 4;
            } elseif ($appointment->recurring == 'yearly') {
                $recurring = 52;
            } else {
                $recurring = 0;
            }

            foreach ($timestamp as $day => $hours) {
                for ($i = 0; $i <= $recurring ; $i++) {

                    if ($i == 0) {
                        $date = Date::parse($day)->format('Y-m-d');
                    } else {
                        $date = Date::parse($day)->addWeek($i)->format('Y-m-d');
                    }

                    foreach ($hours as $hour_key => $hour) {
                        $starting_hours = Date::parse($hour)->format('H:i:s');
                        $before_schedule_appointment = Date::now()->addHour($appointment->before_schedule_appointment)->format('H:i:s');
                        $after_schedule_appointment = Date::now()->addDay($appointment->after_schedule_appointment)->format('Y-m-d');
                        $today = Date::now()->format('Y-m-d');

                        if ($date == $today && $starting_hours <= $before_schedule_appointment) {
                            continue;
                        } else if ($date >= $after_schedule_appointment) {
                            continue;
                        }

                        $count = count($hours);

                        if ($count > $hour_key + 1) {
                            $ending_hours = Date::parse($hours[$hour_key + 1])->format('H:i:s');
                        } else {
                            continue;
                        }

                        $scheduled = Scheduled::where('date', $date)
                                              ->where('starting_time', $hour)
                                              ->first();

                        if (!empty($scheduled) && $scheduled->status == 'approve') {
                            $events[] = [
                                'title' => $appointment->appointment_name,
                                'start' => $date . 'T' . $starting_hours,
                                'end' => $date . 'T' . $ending_hours,
                                'backgroundColor' => '#FF0000',
                                'borderColor' => '#6da252',
                                'extendedProps' => [
                                    'status' => $scheduled->status,
                                    'appointment_id' => $appointment->id,
                                ],
                            ];
                        } else {
                            $events[] = [
                                'title' => $appointment->appointment_name,
                                'start' => $date . 'T' . $starting_hours,
                                'end' => $date . 'T' . $ending_hours,
                                'backgroundColor' => '#6da252',
                                'borderColor' => '#6da252',
                                'extendedProps' => [
                                    'status' => '',
                                    'appointment_id' => $appointment->id,
                                ],
                            ];
                        }
                    }
                }
            }
        } else {
            foreach ($appointment->employees as $key => $employee) {
                $days = json_decode($employee->week_days);

                foreach ($days as $day) {
                    $date = Date::parse($day)->format('Y-m-d');

                    $starting_time = strtotime($employee->starting_time);
                    $ending_time = strtotime($employee->ending_time);

                    $duration_time = explode(':', $appointment->appointment_duration);

                    foreach ($duration_time as $time_key => $time) {
                        if ((int)$time < 10) {
                            $duration_time[$time_key] =  str_replace('0', '', $time);
                        }
                    }

                    $timestamp[$employee->employee_id][$day][] = $employee->starting_time;

                    for ($i = $employee->starting_time; $i < $employee->ending_time;) {
                        foreach ($duration_time as $key => $time) {
                            if ($time == '') {
                                $duration_time[$key] = 0;
                            }
                        }

                        $today = Date::today()->toDateString();
                        $day_control = date('Y-m-d', strtotime($i. '+' . $duration_time[0] . 'hour' . $duration_time[1] .'minute'));

                        if ($today == $day_control) {
                            $rand_time = date('H:i', strtotime($i. '+' . $duration_time[0] . 'hour' . $duration_time[1] .'minute'));
                            $timestamp[$employee->employee_id][$day][] = $rand_time;
                            $i = $rand_time;
                        } else {
                            break;
                        }
                    }
                }

                if ($appointment->recurring == 'monthly') {
                    $recurring = 4;
                } elseif ($appointment->recurring == 'yearly') {
                    $recurring = 52;
                } else {
                    $recurring = 0;
                }

                foreach ($timestamp as $employee_id => $days) {
                    foreach ($days as $day => $hours) {
                        for ($i = 0; $i <= $recurring ; $i++) {
                            if ($i == 0) {
                                $date = Date::parse($day)->format('Y-m-d');
                            } else {
                                $date = Date::parse($day)->addWeek($i)->format('Y-m-d');
                            }

                            foreach ($hours as $hour_key => $hour) {
                                $starting_hours = Date::parse($hour)->format('H:i:s');
                                $before_schedule_appointment = Date::now()->addHour($appointment->before_schedule_appointment)->format('H:i:s');
                                $after_schedule_appointment = Date::now()->addDay($appointment->after_schedule_appointment)->format('Y-m-d');
                                $today = Date::now()->format('Y-m-d');

                                if ($date == $today && $starting_hours <= $before_schedule_appointment) {
                                    continue;
                                } elseif ($date >= $after_schedule_appointment) {
                                    continue;
                                }

                                $count = count($hours);

                                if ($count > $hour_key + 1) {
                                    $ending_hours = Date::parse($hours[$hour_key + 1])->format('H:i:s');
                                } else {
                                    continue;
                                }

                                $scheduled = Scheduled::where('date', $date)
                                                      ->where('starting_time', $hour)
                                                      ->where('employee_id', $employee->id)
                                                      ->first();

                                if (!empty($scheduled) && $scheduled->status == 'approve') {
                                    $events[] = [
                                        'title' => $appointment->appointment_name . ' ( ' . $employee->employee->contact->name . ' )',
                                        'start' => $date . 'T' . $starting_hours,
                                        'end' => $date . 'T' . $ending_hours,
                                        'backgroundColor' => '#FF0000',
                                        'borderColor' => '#6da252',
                                        'extendedProps' => [
                                            'status' => $scheduled->status,
                                            'employee_id' => $employee->id,
                                            'appointment_id' => $appointment->id,
                                        ],
                                    ];
                                } else {
                                    $events[] = [
                                        'title' => $appointment->appointment_name . ' ( ' . $employee->employee->contact->name . ' )',
                                        'start' => $date . 'T' . $starting_hours,
                                        'end' => $date . 'T' . $ending_hours,
                                        'backgroundColor' => '#6da252',
                                        'borderColor' => '#6da252',
                                        'extendedProps' => [
                                            'status' => '',
                                            'employee_id' => $employee->id,
                                            'appointment_id' => $appointment->id,
                                        ],
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        return view('appointments::appointments.show', compact('appointment', 'question_type_select', 'question_type_text', 'events', 'values'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Appointment  $appointment
     *
     * @return Response
     */
    public function edit(Appointment $appointment)
    {
        $questions = Question::pluck('question', 'id');
        $employees = Contact::where('type', 'employee')->enabled()->pluck('name', 'id');

        $reminders = [
            '15 Minutes', '30 Minutes', '1 Hours',
            '3 Hours', '6 Hours', '1 Days'
        ];

        $week_days = [
            'sunday' => trans('appointments::general.days.sunday'),
            'monday' => trans('appointments::general.days.monday'),
            'tuesday' => trans('appointments::general.days.tuesday'),
            'wednesday' => trans('appointments::general.days.wednesday'),
            'thursday' => trans('appointments::general.days.thursday'),
            'friday' => trans('appointments::general.days.friday'),
            'saturday' => trans('appointments::general.days.saturday'),
        ];

        $recurring = [
            'weekly' => trans('appointments::general.recurring.weekly'),
            'monthly' => trans('appointments::general.recurring.monthly'),
            'yearly' => trans('appointments::general.recurring.yearly'),
        ];

        $appointment_type = [
            'free' => trans('appointments::general.free'),
            'paid' => trans('appointments::general.paid'),
        ];

        $owner = [
            'admin'   => trans('appointments::general.admin'),
            'employee' => trans('appointments::general.employee'),
        ];

        $selected_employees = $appointment->employees;
        foreach ($selected_employees as $key => $selected_employee) {
            $selected_employees[$key]->ending_time = $selected_employee->ending_time;
            $selected_employees[$key]->starting_time = $selected_employee->starting_time;
            $selected_employees[$key]->week_days = json_decode($selected_employee->week_days);
        }

        $currency = Currency::where('code', '=', setting('default.currency'))->first();

        return view('appointments::appointments.edit', compact('appointment', 'selected_employees', 'owner', 'appointment_type', 'currency', 'reminders', 'recurring', 'week_days', 'questions', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Appointment $appointment
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Appointment $appointment, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateAppointment($appointment, $request));

        if ($response['success']) {
            $response['redirect'] = route('appointments.appointments.index');

            $message = trans('messages.success.updated', ['type' => $appointment->appointment_name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('appointments.appointments.edit', $appointment->id);

            flash($response['message'])->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Enable the specified resource.
     *
     * @param  Appointment $appointment
     *
     * @return Response
     */
    public function enable(Appointment $appointment)
    {
        $response = $this->ajaxDispatch(new UpdateAppointment($appointment, request()->merge(['enabled' => 1])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => $appointment->name]);
        }

        return response()->json($response);
    }

    /**
     * Disable the specified resource.
     *
     * @param  Appointment $appointment
     *
     * @return Response
     */
    public function disable(Appointment $appointment)
    {
        $response = $this->ajaxDispatch(new UpdateAppointment($appointment, request()->merge(['enabled' => 0])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.disabled', ['type' => $appointment->name]);
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Appointment $appointment
     *
     * @return Response
     */
    public function destroy(Appointment $appointment)
    {
        $response = $this->ajaxDispatch(new DeleteAppointment($appointment));

        $response['redirect'] = route('appointments.appointments.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $appointment->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
