<?php

namespace Modules\Helpdesk\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;
use Modules\Helpdesk\Models\Priority;

class Priorities extends Seeder
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

        $priorities = [
            [
                'company_id' => $company_id,
                'name' => 'urgent',
                'order' => 1,
                'default' => false,
            ],
            [
                'company_id' => $company_id,
                'name' => 'high',
                'order' => 2,
                'default' => false,
            ],
            [
                'company_id' => $company_id,
                'name' => 'medium',
                'order' => 3,
                'default' => true,
            ],
            [
                'company_id' => $company_id,
                'name' => 'low',
                'order' => 4,
                'default' => false,
            ],
        ];

        foreach ($priorities as $priority) {
            Priority::firstOrCreate($priority)
                ->update(['created_from' => 'helpdesk::seed']); // To ensure 'firstOrCreate' works, we need to update the new field 'created_from' afterwards.
        }
    }
}
