<?php

namespace Modules\Projects\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Auth\Permission;
use App\Traits\Permissions;

class Version206 extends Listener
{
    use Permissions;

    const ALIAS = 'projects';

    const VERSION = '2.0.6';

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

        $this->updatePermissions();
    }

    protected function updatePermissions()
    {
        Permission::whereIn('name', [
            'create-projects',
            'read-projects',
            'update-projects',
            'delete-projects',
            'create-project-tasks',
            'read-project-tasks',
            'update-project-tasks',
            'delete-project-tasks',
            'create-project-subtasks',
            'read-project-subtasks',
            'update-project-subtasks',
            'delete-project-subtasks',
            'create-project-discussions',
            'read-project-discussions',
            'update-project-discussions',
            'delete-project-discussions',
            'create-project-comments',
        ])->each(function ($permission) {
            $permission->delete();
        });

        $this->attachPermissionsToAdminRoles([
            'projects-projects' => 'c,r,u,d',
            'projects-tasks' => 'c,r,u,d',
            'projects-subtasks' => 'c,r,u,d',
            'projects-discussions' => 'c,r,u,d',
            'projects-comments' => 'c',
            'projects-discussion-likes' => 'c,d',
        ]);
    }
}
