<?php

namespace Modules\Leaves\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;
use Modules\Leaves\Models\Settings\LeaveType;
use Modules\Leaves\Models\Settings\Policy;
use Modules\Leaves\Models\Settings\Year;

class Policies extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        if (!$leave_type = LeaveType::where('name', trans('leaves::general.default.leave_types.sick_leave.name'))->first()) {
            return;
        }

        if (!$year = Year::where('name', date('Y'))->first()) {
            return;
        }

        Policy::create([
            'company_id'       => $this->command->argument('company'),
            'leave_type_id'    => $leave_type->id,
            'year_id'          => $year->id,
            'name'             => trans('leaves::general.default.policies.annual_leave.name'),
            'days'             => 5,
            'applicable_after' => 3,
            'carryover_days'   => 1,
            'is_paid'          => true,
        ]);
    }
}
