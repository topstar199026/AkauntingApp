<?php

namespace Modules\Projects\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Setting\EmailTemplate;
use App\Traits\Permissions;

class Version307 extends Listener
{
    use Permissions;

    const ALIAS = 'projects';

    const VERSION = '3.0.7';

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(UpdateFinished $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        $this->updateTemplates();
    }

    protected function updateTemplates()
    {
        $templates = [
            [
                'alias' => 'projects_task_assignment_member',
                'class' => 'Modules\Projects\Notifications\Tasks\MemberAssignment',
                'name' => 'projects::settings.email.templates.projects_task_assignment_member',
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::firstOrCreate([
                'company_id' => company_id(),
                'alias' => $template['alias'],
                'class' => $template['class'],
                'name' => $template['name'],
                'subject' => trans('projects::email_templates.' . $template['alias'] . '.subject'),
                'body' => trans('projects::email_templates.' . $template['alias'] . '.body'),
            ]);
        }
    }
}
