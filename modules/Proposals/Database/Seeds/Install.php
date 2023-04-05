<?php

namespace Modules\Proposals\Database\Seeds;

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
        $this->call(EmailTemplates::class);
        $this->call(Pipelines::class);
    }
}
