<?php

namespace Modules\Calendar\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Traits\Permissions;

class Version213 extends Listener
{
    use Permissions;

    const ALIAS = 'calendar';

    const VERSION = '2.1.3';

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
        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-calendar' => 'c,r,u,d',
        ]);
    }
}
