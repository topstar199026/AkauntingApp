<?php

namespace Modules\Calendar\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

use Modules\Calendar\Http\Requests\Setting as Request;

class Settings extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        $days = (object) [
            trans('calendar::general.days.sunday'),
            trans('calendar::general.days.monday'),
            trans('calendar::general.days.tuesday'),
            trans('calendar::general.days.wednesday'),
            trans('calendar::general.days.thursday'),
            trans('calendar::general.days.friday'),
            trans('calendar::general.days.saturday')
        ];

        return view('calendar::settings.edit', compact('days'));
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
        setting()->set('calendar.first_day', $request['first_day']);
        setting()->set('calendar.holidays.enabled', $request['enabled']);
        setting()->save();

        if (config('setting.cache.enabled')) {
            Cache::forget(setting()->getCacheKey());
        }

        $response = [
            'status' => null,
            'success' => true,
            'error' => false,
            'data' => null,
            'redirect' => route('calendar.settings.edit'),
        ];

        session(['aka_notify' => $response]);

        if ($response['success']) {

            $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
