<?php

namespace Modules\Appointments\Http\Controllers\Portal;

use App\Models\Common\Contact;
use App\Abstracts\Http\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Modules\Appointments\Jobs\Scheduled\CreateScheduled;
use Modules\Appointments\Jobs\Scheduled\DeleteScheduled;
use Modules\Appointments\Jobs\Scheduled\UpdateScheduled;
use Modules\Appointments\Models\Scheduled as BaseScheduled;
use Modules\Appointments\Http\Requests\Scheduled as Request;

class Scheduled extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $contact = Contact::where('name', user()->name )->where('type', 'customer')->first();

        $scheduled = BaseScheduled::where('contact_id', $contact->id)->collect();

        return $this->response('appointments::portal.scheduled.index', compact('scheduled'));
    }

    /**
     * Dismiss the specified resource.
     *
     * @param  BaseScheduled $scheduled
     *
     * @return Response
     */
    public function dismiss(BaseScheduled $scheduled)
    {
        $response = $this->ajaxDispatch(new UpdateScheduled($scheduled, request()->merge(['status' => 'dismiss'])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => $scheduled->name]);
        }

        return redirect()->route('portal.appointments.scheduled.index');
    }
}
