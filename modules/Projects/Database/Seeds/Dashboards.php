<?php

namespace Modules\Projects\Database\Seeds;

use App\Abstracts\Model;
use App\Jobs\Common\CreateDashboard;
use App\Traits\Jobs;
use Illuminate\Database\Seeder;

class Dashboards extends Seeder
{
    use Jobs;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $company_id = $this->command->argument('company');

        $this->dispatch(new CreateDashboard([
            'company_id' => $company_id,
            'name' => trans('projects::general.title'),
            'all_users' => true,
            'default_widgets' => 'projects',
        ]));
    }
}
