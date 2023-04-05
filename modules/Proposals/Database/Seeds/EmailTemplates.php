<?php

namespace Modules\Proposals\Database\Seeds;

use App\Abstracts\Model;
use App\Models\Setting\EmailTemplate;
use Illuminate\Database\Seeder;
use Modules\Proposals\Notifications\Proposal;

class EmailTemplates extends Seeder
{
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

        $templates = [
            [
                'alias' => 'proposal_send_customer',
                'class' => Proposal::class,
                'name'  => 'proposals::settings.proposal_send_customer',
            ]
        ];

        foreach ($templates as $template) {
            EmailTemplate::create(
                [
                    'company_id' => $company_id,
                    'alias'      => $template['alias'],
                    'class'      => $template['class'],
                    'name'       => $template['name'],
                    'subject'    => trans('proposals::email_templates.' . $template['alias'] . '.subject'),
                    'body'       => trans('proposals::email_templates.' . $template['alias'] . '.body'),
                ]
            );
        }
    }
}
