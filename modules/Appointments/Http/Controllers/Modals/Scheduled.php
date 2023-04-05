<?php

namespace Modules\Appointments\Http\Controllers\Modals;

use Date;
use App\Abstracts\Http\Controller;
use Modules\Employees\Models\Employee;
use Illuminate\Http\Request as Request;
use Modules\Appointments\Jobs\Scheduled\CreateScheduled;
use Modules\Appointments\Jobs\Scheduled\DeleteScheduled;
use Modules\Appointments\Jobs\Scheduled\UpdateScheduled;
use Modules\Appointments\Notifications\Appointment as Notification;

class Scheduled extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-settings-categories')->only(['create', 'store', 'duplicate', 'import']);
        $this->middleware('permission:read-settings-categories')->only(['index', 'show', 'edit', 'export']);
        $this->middleware('permission:update-settings-categories')->only(['update', 'enable', 'disable']);
        $this->middleware('permission:delete-settings-categories')->only('destroy');
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

        $html = view('appointments::modals.appointment', compact('starting_hour', 'ending_hour', 'date', 'request'))->render();

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
            'redirect' => route('appointments.appointments.show', $request['appointment_id']),
            'data' => [],
        ];

        $message = trans('messages.success.added', ['type' => trans('appointments::message.scheduled')]);

        flash($message)->success();

        return response()->json($response);
    }
}
