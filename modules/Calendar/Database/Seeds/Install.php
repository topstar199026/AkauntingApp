<?php

namespace Modules\Calendar\Database\Seeds;

use Illuminate\Database\Seeder;

class Install extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Permissions::class);
        $this->call(Settings::class);
    }
}
