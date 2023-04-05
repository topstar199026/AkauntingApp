<?php

namespace Modules\Leaves\Database\Seeds;

use Illuminate\Database\Seeder;

class LeavesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Permissions::class);
        $this->call(Widgets::class);
        $this->call(Years::class);
        $this->call(LeaveTypes::class);
        $this->call(Policies::class);
    }
}
