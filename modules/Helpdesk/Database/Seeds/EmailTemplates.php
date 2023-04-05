<?php

namespace Modules\Helpdesk\Database\Seeds;

use App\Abstracts\Model;
use App\Jobs\Setting\CreateEmailTemplate;
use App\Traits\Jobs;
use Illuminate\Database\Seeder;

class EmailTemplates extends Seeder
{
    use Jobs;

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
                'alias' => 'ticket_created',
                'class' => 'Modules\Helpdesk\Notifications\Ticket',
                'name' => 'helpdesk::settings.email.templates.ticket_created',
            ],
            [
                'alias' => 'ticket_updated',
                'class' => 'Modules\Helpdesk\Notifications\Ticket',
                'name' => 'helpdesk::settings.email.templates.ticket_updated',
            ],
            [
                'alias' => 'reply_created',
                'class' => 'Modules\Helpdesk\Notifications\Reply',
                'name' => 'helpdesk::settings.email.templates.reply_created',
            ],
        ];

        foreach ($templates as $template) {
            $this->dispatch(new CreateEmailTemplate([
                'company_id' => $company_id,
                'alias' => $template['alias'],
                'class' => $template['class'],
                'name' => $template['name'],
                'subject' => trans('helpdesk::email_templates.' . $template['alias'] . '.subject'),
                'body' => trans('helpdesk::email_templates.' . $template['alias'] . '.body'),
                'created_from' => 'helpdesk::seed',
            ]));
        }
    }
}
