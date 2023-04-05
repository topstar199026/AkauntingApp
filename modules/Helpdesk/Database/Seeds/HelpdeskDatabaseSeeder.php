<?php

namespace Modules\Helpdesk\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;

class HelpdeskDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(Categories::class);
        $this->call(Statuses::class);
        $this->call(Priorities::class);
        $this->call(Reports::class);
        $this->call(EmailTemplates::class);
        $this->call(Dashboards::class);

        Model::reguard();
    }
}
