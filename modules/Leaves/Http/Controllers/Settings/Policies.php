<?php

namespace Modules\Leaves\Http\Controllers\Settings;

use App\Abstracts\Http\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Employees\Models\Employee;
use Modules\Employees\Models\Department;
use Modules\Leaves\Http\Requests\Policy as Request;
use Modules\Leaves\Jobs\Settings\CreatePolicy;
use Modules\Leaves\Jobs\Settings\DeletePolicy;
use Modules\Leaves\Jobs\Settings\UpdatePolicy;
use Modules\Leaves\Models\Settings\LeaveType;
use Modules\Leaves\Models\Settings\Policy;
use Modules\Leaves\Models\Settings\Year;

class Policies extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-leaves-entitlements')->only('index');
        $this->middleware('permission:update-leaves-settings')->only(['create', 'store', 'destroy', 'edit', 'update']);
    }

    public function index()
    {
        $policies = Policy::with(['leave_type', 'year'])
            ->collect('name');

        return $this->response('leaves::settings.policies.index', compact('policies'));
    }

    public function create()
    {
        $leave_types = LeaveType::orderBy('name')->pluck('name', 'id');

        $leave_years = Year::orderBy('name')->pluck('name', 'id');

        $departments = Department::enabled()->orderBy('name')->pluck('name', 'id');

        $genders = Employee::getAvailableGenders();

        return view('leaves::settings.policies.create', compact('leave_types', 'leave_years', 'departments', 'genders'));
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new CreatePolicy($request));

        if ($response['success']) {
            $response['redirect'] = route('leaves.settings.policies.index');

            $message = trans('messages.success.added', ['type' => trans('leaves::general.leave_policy')]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('leaves.settings.policies.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function destroy(Policy $policy): JsonResponse
    {
        $response = $this->ajaxDispatch(new DeletePolicy($policy));

        $response['redirect'] = route('leaves.settings.policies.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $policy->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function edit(Policy $policy)
    {
        $leave_types = LeaveType::orderBy('name')->pluck('name', 'id');

        $leave_years = Year::orderBy('name')->pluck('name', 'id');

        $departments = Department::enabled()->orderBy('name')->pluck('name', 'id');

        $genders = Employee::getAvailableGenders();

        return view('leaves::settings.policies.edit', compact('policy', 'leave_types', 'leave_years', 'departments', 'genders'));
    }

    public function update(Policy $policy, Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new UpdatePolicy($policy, $request));

        if ($response['success']) {
            $response['redirect'] = route('leaves.settings.policies.index');

            $message = trans('messages.success.updated', ['type' => $policy->name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('leaves.settings.policies.edit', $policy->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }
}
