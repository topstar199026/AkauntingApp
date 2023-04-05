<?php

namespace Modules\Leaves\Http\Controllers\Settings;

use App\Abstracts\Http\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Leaves\Http\Requests\LeaveType as Request;
use Modules\Leaves\Jobs\Settings\CreateLeaveType;
use Modules\Leaves\Jobs\Settings\DeleteLeaveType;
use Modules\Leaves\Jobs\Settings\UpdateLeaveType;
use Modules\Leaves\Models\Settings\LeaveType;

class LeaveTypes extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:update-leaves-settings');
    }

    public function index()
    {
        $leave_types = LeaveType::collect();

        return $this->response('leaves::settings.leave_types.index', compact('leave_types'));
    }

    public function create()
    {
        return view('leaves::settings.leave_types.create');
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new CreateLeaveType($request));

        if ($response['success']) {
            $response['redirect'] = route('leaves.settings.leave-types.index');

            $message = trans('messages.success.added', ['type' => trans_choice('leaves::general.leave_types', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('leaves.settings.leave-types.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function destroy(LeaveType $leave_type): JsonResponse
    {
        $response = $this->ajaxDispatch(new DeleteLeaveType($leave_type));

        $response['redirect'] = route('leaves.settings.leave-types.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $leave_type->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function edit(LeaveType $leave_type)
    {
        return view('leaves::settings.leave_types.edit', compact('leave_type'));
    }

    public function update(LeaveType $leave_type, Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new UpdateLeaveType($leave_type, $request));

        if ($response['success']) {
            $response['redirect'] = route('leaves.settings.leave-types.index');

            $message = trans('messages.success.updated', ['type' => $leave_type->name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('leaves.settings.leave_types.edit', $leave_type->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
