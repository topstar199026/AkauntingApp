<?php

namespace Modules\Calendar\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Calendar\Events\CalendarEventCreated;

class Main extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        event(new CalendarEventCreated($data = new \stdClass()));

        return view('calendar::index', ['events' => $data->events ?? null]);
    }
}
