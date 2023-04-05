<?php

namespace Modules\Leaves\Http\Controllers\Modals;

use App\Abstracts\Http\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Modules\Leaves\Http\Requests\Modals\Leave as Request;
use Modules\Leaves\Jobs\DeleteAllowance;
use Modules\Leaves\Jobs\RegisterLeave;
use Modules\Leaves\Models\Allowance;
use Modules\Leaves\Models\Entitlement;

class Leaves extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-leaves-leaves')->only('create', 'store');
        $this->middleware('permission:delete-leaves-leaves')->only('destroy');
    }

    public function create(Entitlement $entitlement = null): JsonResponse
    {
        $entitlements = [];

        Entitlement::with(['employee.contact', 'policy.year'])
            ->cursor()
            ->each(function ($entitlement) use (&$entitlements) {
                $entitlements[$entitlement->id] = $entitlement->employee->contact->name . ' '
                    . $entitlement->policy->name . ' '
                    . $entitlement->policy->year->name;
            });

        $date = request()->input('date', now()->format('Y-m-d'));

        $html = view('leaves::modals.leaves.register', compact('entitlement','entitlements', 'date'))->render();

        return response()->json([
            'success' => true,
            'error'   => false,
            'data'    => null,
            'message' => null,
            'html'    => $html,
            'title'   => trans('leaves::entitlements.register_leave'),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $response = $this->ajaxDispatch(new RegisterLeave($request));

        if ($request->input('from_calendar')) {
            $allowance = $response['data'];

            $allowance->load((['employee.contact', 'entitlement.policy']));

            $response['leave'] = [
                'title'           => $allowance->employee->contact->name
                    . ' (' . $allowance->days . ' ' . strtolower(trans_choice('leaves::allowances.days', $allowance->days)) . ' '
                    . $allowance->entitlement->policy->name . ')',
                'start'           => $allowance->start_date,
                'end'             => Carbon::parse($allowance->end_date)->addDay()->format('Y-m-d'),
                'type'            => 'holiday',
                'backgroundColor' => '#6da252',
                'borderColor'     => '#6da252',
                'extendedProps'   => [
                    'employee_route' => route('employees.employees.edit', $allowance->employee->id),
                    'employee'       => $allowance->employee->contact->name,
                    'policy_route'   => route('leaves.settings.policies.edit', $allowance->entitlement->policy->id),
                    'policy'         => $allowance->entitlement->policy->name,
                    'start_date'     => company_date($allowance->start_date),
                    'end_date'       => company_date($allowance->end_date),
                    'days'           => $allowance->days,
                    'delete_route'   => route('leaves.modals.leaves.destroy', $allowance->id),
                ],
            ];
        } else {
            $response['redirect'] = route('leaves.entitlements.index');
        }

        if ($response['success']) {
            $message = trans('messages.success.added', ['type' => trans_choice('leaves::general.leaves', 1)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function destroy(Allowance $allowance): JsonResponse
    {
        return response()->json($this->ajaxDispatch(new DeleteAllowance($allowance)));
    }
}
