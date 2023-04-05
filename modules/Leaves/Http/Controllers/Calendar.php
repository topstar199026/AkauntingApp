<?php

namespace Modules\Leaves\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Support\Carbon;
use Modules\Leaves\Models\Allowance;

class Calendar extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-leaves-calendar')->only('index');
    }

    public function index()
    {
        $leaves = Allowance::with(['employee.contact', 'entitlement.policy'])
            ->used()
            ->get()
            ->map(function ($allowance) {
                return [
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
            });

        return view('leaves::calendar.index', compact('leaves'));
    }
}
