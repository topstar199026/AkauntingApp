<?php

namespace Modules\Leaves\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Leaves\Models\Entitlement;

class AddLeavesTab
{
    public function compose(View $view)
    {
        if (user()->cannot('read-leaves-entitlements')) {
            return;
        }

        $route = route('leaves.entitlements.create'). '?employee_id=' . $view->getData()['employee']->id;

        $entitlements = Entitlement::where('employee_id', $view->getData()['employee']->id)->with(['policy.year', 'employee.contact', 'allowances'])->collect();

        $view->getFactory()->startPush('leaves_employee_content', view('leaves::partials.employee.entitlements', compact('route', 'entitlements')));
    }
}
