<?php

namespace Modules\Appointments\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Appointments\Models\Question;
use Modules\Appointments\Http\Requests\Setting as Request;

class Settings extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        $questions = Question::pluck('question', 'id');

        $reminders = [
            '15 Minutes', '30 Minutes', '1 Hours',
            '3 Hours', '6 Hours', '1 Days'
        ];

        $recurring = [
            'weekly' => trans('appointments::general.recurring.weekly'),
            'monthly' => trans('appointments::general.recurring.monthly'),
            'yearly' => trans('appointments::general.recurring.yearly'),
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

        return view('appointments::settings.edit', compact('reminders', 'recurring', 'questions', 'week_days'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
        setting()->set('appointments.appointment_duration', $request['appointment_duration']);
        setting()->set('appointments.reminders', $request['reminders']);
        setting()->set('appointments.before_schedule_appointment', $request['before_schedule_appointment']);
        setting()->set('appointments.after_schedule_appointment', $request['after_schedule_appointment']);
        setting()->set('appointments.allow_cancelled', $request['allow_cancelled']);
        setting()->set('appointments.recurring', $request['recurring']);
        setting()->set('appointments.approval_control', $request['approval_control']);
        setting()->set('appointments.question_ids', json_encode($request['question_ids']));
        setting()->set('appointments.week_days', json_encode($request['week_days']));
        setting()->set('appointments.starting_time', $request['starting_time']);
        setting()->set('appointments.ending_time', $request['ending_time']);

        setting()->save();

        if (config('setting.cache.enabled')) {
            Cache::forget(setting()->getCacheKey());
        }

        $response = [
            'success' => true,
            'error' => false,
            'redirect' => route('appointments.settings.edit'),
            'data' => [],
        ];

        if ($response['success']) {

            $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error();
        }

        return response()->json($response);
    }
}
