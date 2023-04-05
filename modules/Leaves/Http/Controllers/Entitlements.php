<?php

namespace Modules\Leaves\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Employees\Models\Department;
use Modules\Leaves\Http\Requests\Entitlement as Request;
use Modules\Leaves\Jobs\CreateEntitlement;
use Modules\Leaves\Jobs\DeleteEntitlement;
use Modules\Leaves\Models\Employee;
use Modules\Leaves\Models\Entitlement;
use Modules\Leaves\Models\Settings\LeaveType;
use Modules\Leaves\Models\Settings\Policy;
use Modules\Leaves\Models\Settings\Year;

class Entitlements extends Controller
{
    public function index()
    {
        $entitlements = Entitlement::with(['policy.year', 'employee.contact', 'allowances'])->collect();

        return view('leaves::entitlements.index', compact('entitlements'));
    }

    public function create()
    {
        $leave_types = LeaveType::orderBy('name')->pluck('name', 'id');

        $leave_years = Year::orderBy('name')->pluck('name', 'id');

        $departments = Department::enabled()->orderBy('name')->pluck('name', 'id');

        $genders = Employee::getAvailableGenders();

        $leave_policies = Policy::orderBy('name')->pluck('name', 'id');

        $employees = Employee::enabled()
            ->has('contact')
            ->with('contact')
            ->get()
            ->map(function ($employee) {
                $employee->name = $employee->contact->name;
                $employee->name_uppercase = mb_strtoupper($employee->contact->name);

                return $employee;
            })
            ->sortBy('name_uppercase')
            ->pluck('name', 'id');

        return view('leaves::entitlements.create', compact('leave_types', 'leave_years', 'departments', 'genders', 'leave_policies', 'employees'));
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new CreateEntitlement($request));

        if ($response['success']) {
            $response['redirect'] = route('leaves.entitlements.index');

            $message = trans('messages.success.added', ['type' => trans_choice('leaves::general.entitlements', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('leaves.entitlements.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function destroy(Entitlement $entitlement): JsonResponse
    {
        $response = $this->ajaxDispatch(new DeleteEntitlement($entitlement));

        $response['redirect'] = route('leaves.entitlements.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => trans_choice('leaves::general.entitlements', 1)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function findPolicies(): JsonResponse
    {
        $policies = Policy::usingSearchString(request()->get('search'))
            ->pluck('name', 'id');

        return response()->json($policies);
    }

    public function findEmployees(): JsonResponse
    {
        $policies = Employee::enabled()
            ->has('contact')
            ->with('contact')
            ->usingSearchString(request()->get('search'))
            ->get()
            ->map(function ($employee) {
                $employee->name = $employee->contact->name;
                $employee->name_uppercase = mb_strtoupper($employee->contact->name);

                return $employee;
            })
            ->sortBy('name_uppercase')
            ->pluck('name', 'id');

        return response()->json($policies);
    }
}
