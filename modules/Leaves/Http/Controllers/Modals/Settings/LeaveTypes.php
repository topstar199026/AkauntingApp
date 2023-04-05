<?php

namespace Modules\Leaves\Http\Controllers\Modals\Settings;

use App\Abstracts\Http\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Leaves\Http\Requests\LeaveType as Request;
use Modules\Leaves\Jobs\Settings\CreateLeaveType;

class LeaveTypes extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:update-leaves-settings');
    }

    public function create(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'error'   => false,
            'message' => 'null',
            'html'    => view('leaves::modals.settings.leave_types.create')->render(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new CreateLeaveType($request));

        if ($response['success']) {
            $response['message'] = trans('messages.success.added', ['type' => trans_choice('leaves::general.leave_types', 1)]);
        }

        return response()->json($response);
    }
}
