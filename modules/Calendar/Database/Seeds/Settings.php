<?php

namespace Modules\Calendar\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;

class Settings extends Seeder
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

        setting()->setExtraColumns(['company_id' => $company_id]);
        setting()->forgetAll();
        setting()->load(true);

        setting()->set('calendar.first_day', 0);

        setting()->save();
    }
}