<?php

namespace Modules\Appointments\Http\Controllers\Portal;

use App\Models\Common\Contact;
use App\Abstracts\Http\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request as Request;
use Modules\Appointments\Models\Question;
use Modules\Appointments\Models\Scheduled;
use Modules\Appointments\Models\Appointment;
use Modules\Employees\Models\Employee;
use Modules\Appointments\Jobs\Appointment\CreateAppointment;
use Modules\Appointments\Jobs\Appointment\DeleteAppointment;
use Modules\Appointments\Jobs\Appointment\UpdateAppointment;
use Modules\Appointments\Jobs\Scheduled\CreateScheduled;
use Modules\Appointments\Jobs\Scheduled\DeleteScheduled;
use Modules\Appointments\Jobs\Scheduled\UpdateScheduled;
use Date;

class Appointments extends Controller
{
    public function index()
    {
        $appointments = Appointment::collect();

        return $this->response('appointments::portal.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $starting_hour = Date::parse($request->start)->setTimezone(setting('localisation.timezone'))->format('H:i');
        $ending_hour = Date::parse($request->end)->setTimezone(setting('localisation.timezone'))->format('H:i');
        $date = Date::parse($request->end)->format('Y-m-d');

        $html = view('appointments::portal.modals.appointment', compact('starting_hour', 'ending_hour', 'date', 'request'))->render();

        return response()->json([
            'success' => true,
            'error' => false,
            'message' => 'null',
            'html' => $html,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateScheduled($request->input()));

        $response = [
            'success' => true,
            'error' => false,
            'redirect' => route('portal.appointments.appointments.show', $request['appointment_id']),
            'data' => [],
        ];

        $message = trans('messages.success.added', ['type' => trans('appointments::message.scheduled')]);

        flash($message)->success();

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

                if ($question->question_type == 0 ) {
                    $question_type_text[] = $question->question;
                } else {
                    $question_type_select[] = $question->question;

                    foreach ($question->answers as $question_value) {
                        $values[] =  $question_value->avaible_answer;
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

        return view('appointments::portal.appointments.show', compact('appointment', 'question_type_select', 'question_type_text', 'events', 'values'));
    }

        /**
     * Show the form for viewing the specified resource.
     *
     * @param  Appointment  $appointment
     *
     * @return Response
     */
    public function signed(Appointment $appointment)
    {
        $values = $question_type_select = $question_type_text = $events = $timestamp = [];
        $question_ids = json_decode($appointment->question_ids);

        if (!empty($question_ids)) {
            foreach ($question_ids as $key => $question_id) {
                $question = Question::find($question_id);

                if ($question->question_type == 0 ) {
                    $question_type_text[] = $question->question;
                } else {
                    $question_type_select[] = $question->question;

                    foreach ($question->answers as $question_value) {
                        $values[] =  $question_value->avaible_answer;
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

        return view('appointments::portal.appointments.signed', compact('appointment', 'question_type_select', 'question_type_text', 'events', 'values'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
