<?php

namespace Modules\Helpdesk\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;
use Modules\Helpdesk\Models\Status;

class Statuses extends Seeder
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

        $statuses = [
            [
                'company_id' => $company_id,
                'name' => 'open',
                'position' => 'first',
                'flow_id' => 1,
                'flow' => implode(',', [1, 2]),
                'color' => '#fe5d26',
                'notification' => false,
            ],
            [
                'company_id' => $company_id,
                'name' => 'pending',
                'position' => 'middle',
                'flow_id' => 2,
                'flow' => implode(',', [2, 3, 4, 6, 1]),
                'color' => '#f2c078',
                'notification' => false,
            ],
            [
                'company_id' => $company_id,
                'name' => 'on_hold',
                'position' => 'middle',
                'flow_id' => 3,
                'flow' => implode(',', [3, 2, 4, 6]),
                'color' => '#faedca',
                'notification' => false,
            ],
            [
                'company_id' => $company_id,
                'name' => 'solved',
                'position' => 'middle',
                'flow_id' => 4,
                'flow' => implode(',', [4, 2, 5]),
                'color' => '#c1dbb3',
                'notification' => true,
            ],
            [
                'company_id' => $company_id,
                'name' => 'closed',
                'position' => 'last',
                'flow_id' => 5,
                'flow' => implode(',', [5]),
                'color' => '#7ebc89',
                'notification' => false,
            ],
            [
                'company_id' => $company_id,
                'name' => 'spam',
                'position' => 'middle',
                'flow_id' => 6,
                'flow' => implode(',', [6, 2, 5]),
                'color' => '#566246',
                'notification' => false,
            ],
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate($status)
                ->update(['created_from' => 'helpdesk::seed']); // To ensure 'firstOrCreate' works, we need to update the new field 'created_from' afterwards.
        }
    }
}
