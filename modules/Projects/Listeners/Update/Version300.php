<?php

namespace Modules\Projects\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Traits\Permissions;
use Illuminate\Support\Facades\Artisan;

class Version300 extends Listener
{
    use Permissions;

    const ALIAS = 'projects';

    const VERSION = '3.0.0';

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

        $this->updateDatabase();

        $this->updatePermissions();
    }

    protected function updateDatabase()
    {
        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);
    }

    protected function updatePermissions()
    {
        $this->detachPermissionsFromAdminRoles([
            'projects-subtasks' => 'c,r,u,d',
        ]);

        $this->attachPermissionsToAdminRoles([
            'projects-milestones' => 'c,r,u,d',
            'projects-timesheets' => 'c,r,u,d',
            'projects-activities' => 'r',
            'projects-transactions' => 'r',
            'projects-invoices' => 'c',
        ]);
        
        $this->attachPermissionsToPortalRoles([
            'projects-portal-projects' => 'r',
            'projects-portal-tasks' => 'c,r',
            'projects-portal-timesheets' => 'r',
            'projects-portal-milestones' => 'r',
            'projects-portal-activities' => 'r',
            'projects-portal-transactions' => 'r',
            'projects-portal-discussions' => 'c,r',
            'projects-portal-comments' => 'c',
            'projects-portal-discussion-likes' => 'c,d',
        ]);
    }
}
