<?php

namespace Modules\Leaves\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Modules\Leaves\Models\Settings\Year;

class Years extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $now = Carbon::now();

        Year::create([
            'company_id' => $this->command->argument('company'),
            'name'       => $now->year,
            'start_date' => $now->startOfYear()->format('Y-m-d'),
            'end_date'   => $now->endOfYear()->format('Y-m-d'),
        ]);
    }
}
