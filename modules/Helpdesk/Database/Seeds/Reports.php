<?php

namespace Modules\Helpdesk\Database\Seeds;

use App\Abstracts\Model;
use App\Jobs\Common\CreateReport;
use App\Traits\Jobs;
use Illuminate\Database\Seeder;

class Reports extends Seeder
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

        $reports = [
            [
                'company_id' => $company_id,
                'class' => 'Modules\Helpdesk\Reports\TicketSummary',
                'name' => trans('helpdesk::reports.ticket_name_s'),
                'description' => trans('helpdesk::reports.ticket_description_s'),
                'settings' => ['group' => 'status', 'period' => 'monthly', 'chart' => 'line'],
            ],
            [
                'company_id' => $company_id,
                'class' => 'Modules\Helpdesk\Reports\TicketSummary',
                'name' => trans('helpdesk::reports.ticket_name_c'),
                'description' => trans('helpdesk::reports.ticket_description_c'),
                'settings' => ['group' => 'category', 'period' => 'monthly', 'chart' => 'line'],
            ],
        ];

        foreach ($reports as $report) {
            $report['created_from'] = 'helpdesk::seed';

            $this->dispatch(new CreateReport($report));
        }
    }
}
