<?php

namespace Modules\Appointments\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Modules\Appointments\Models\Scheduled as BaseScheduled;
use Modules\Appointments\Jobs\Scheduled\CreateScheduled;
use Modules\Appointments\Jobs\Scheduled\DeleteScheduled;
use Modules\Appointments\Jobs\Scheduled\UpdateScheduled;
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
        $scheduled = BaseScheduled::collect();

        return $this->response('appointments::scheduled.index', compact('scheduled'));
    }

    /**
     * Approve the specified resource.
     *
     * @param  BaseScheduled $scheduled
     *
     * @return Response
     */
    public function approve(BaseScheduled $scheduled)
    {
        $response = $this->ajaxDispatch(new UpdateScheduled($scheduled, request()->merge(['status' => 'approve'])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => $scheduled->name]);
        }

        return redirect()->route('appointments.scheduled.index');
    }

    /**
     * Sent the specified resource.
     *
     * @param  BaseScheduled $scheduled
     *
     * @return Response
     */
    public function sent(BaseScheduled $scheduled)
    {
        $response = $this->ajaxDispatch(new UpdateScheduled($scheduled, request()->merge(['status' => 'sent'])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => $scheduled->name]);
        }

        return redirect()->route('appointments.scheduled.index');
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

        return redirect()->route('appointments.scheduled.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  BaseScheduled $scheduled
     *
     * @return Response
    */
    public function destroy(BaseScheduled $scheduled)
    {
        $response = $this->ajaxDispatch(new DeleteScheduled($scheduled));

        $response['redirect'] = route('appointments.scheduled.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $scheduled->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
