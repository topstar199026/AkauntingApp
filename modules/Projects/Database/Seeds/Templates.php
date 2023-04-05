<?php

namespace Modules\Projects\Database\Seeds;

use App\Abstracts\Model;
use App\Models\Setting\EmailTemplate;
use Illuminate\Database\Seeder;

class Templates extends Seeder
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
                'alias' => 'projects_task_assignment_member',
                'class' => 'Modules\Projects\Notifications\Tasks\MemberAssignment',
                'name' => 'projects::settings.email.templates.projects_task_assignment_member',
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::firstOrCreate([
                'company_id' => $company_id,
                'alias' => $template['alias'],
                'class' => $template['class'],
                'name' => $template['name'],
                'subject' => trans('projects::email_templates.' . $template['alias'] . '.subject'),
                'body' => trans('projects::email_templates.' . $template['alias'] . '.body'),
            ]);
        }
    }
}
