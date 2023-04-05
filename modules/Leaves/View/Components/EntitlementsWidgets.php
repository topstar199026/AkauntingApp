<?php

namespace Modules\Leaves\View\Components;

use App\Models\Common\Widget;
use App\Utilities\Widgets;
use Illuminate\View\Component;
use Modules\Leaves\Widgets\EntitlementDays;
use Modules\Leaves\Widgets\TotalDaysAllowed;

class EntitlementsWidgets extends Component
{
    public function render()
    {
        $dashboard = user()->dashboards()->where([
            'company_id' => company_id(),
            'name'       => trans('employees::general.hr'),
            'enabled'    => 1,
        ])->first();

        if (!$dashboard) {
            return '';
        }

        $classes = [
            EntitlementDays::class,
            TotalDaysAllowed::class,
        ];

        $widgets = Widget::where('dashboard_id', $dashboard->id)
            ->whereIn('class', $classes)
            ->orderBy('sort')
            ->get()
            ->filter(function ($widget) {
                return Widgets::canShow($widget->class);
            });

        return view('leaves::components.entitlements_widgets', compact('widgets'));
    }
}
