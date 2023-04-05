<?php

namespace Modules\Appointments\Database\Seeds;

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
        $this->call(EmailTemplates::class);
        $this->call(Permissions::class);
    }
}
