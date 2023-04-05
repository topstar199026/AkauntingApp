<?php

namespace Modules\Leaves\Widgets;

use App\Abstracts\Widget;
use Illuminate\Support\Facades\Route;
use Modules\Leaves\Models\Allowance;
use Modules\Leaves\Models\Entitlement;

class EntitlementDays extends Widget
{
    public $default_name = 'leaves::widgets.entitlement_days';

    public function __construct($model = null)
    {
        parent::__construct($model);

        if (Route::is('leaves.entitlements.index')) {
            $this->views['header'] = 'leaves::partials.widgets.standard_header';
        }
    }

    public function show()
    {
        $colors = [
            'used'      => '#ef3232',
            'remaining' => '#328aef',
        ];

        $used = Allowance::used()->sum('days');

        $entitled = Entitlement::join('leaves_policies', 'leaves_entitlements.policy_id', '=', 'leaves_policies.id')
            ->sum('days');

        $values = [
            'used'      => $used,
            'remaining' => $entitled - $used,
        ];

        foreach ($values as $status => $amount) {
            $this->addToDonut(
                $colors[$status],
                $amount . ' - ' . trans('leaves::widgets.statuses.' . $status),
                $amount
            );
        }

        $chart = $this->getDonutChart(trans_choice('general.expenses', 1));

        return $this->view('widgets.donut_chart', compact('chart'));
    }
}
