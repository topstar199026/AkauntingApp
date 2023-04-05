<?php

namespace Modules\Leaves\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;
use Modules\Leaves\Models\Settings\LeaveType;

class LeaveTypes extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $company_id = $this->command->argument('company');

        $leave_types = [
            [
                'name'        => trans('leaves::general.default.leave_types.casual_leave.name'),
                'description' => trans('leaves::general.default.leave_types.casual_leave.description'),
            ],
            [
                'name'        => trans('leaves::general.default.leave_types.sick_leave.name'),
                'description' => trans('leaves::general.default.leave_types.sick_leave.description'),
            ],
        ];

        foreach ($leave_types as $leave_type) {
            LeaveType::create([
                'company_id'  => $company_id,
                'name'        => $leave_type['name'],
                'description' => $leave_type['description'],
            ]);
        }
    }
}
