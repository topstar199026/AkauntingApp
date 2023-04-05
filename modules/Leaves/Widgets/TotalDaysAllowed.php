<?php

namespace Modules\Leaves\Widgets;

use App\Abstracts\Widget;
use Modules\Leaves\Models\Entitlement;

class TotalDaysAllowed extends Widget
{
    public $default_name = 'leaves::widgets.total_days_allowed';

    public $default_settings = [
        'width' => 'w-full lg:w-2/4 px-12 my-auto',
    ];

    public function show()
    {
        $total_days_allowed = Entitlement::join('leaves_policies', 'leaves_entitlements.policy_id', '=', 'leaves_policies.id')
            ->sum('days');

        return $this->view('leaves::widgets.total_days_allowed', compact('total_days_allowed'));
    }
}
