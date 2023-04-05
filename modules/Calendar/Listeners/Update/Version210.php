<?php

namespace Modules\Calendar\Listeners\Update;

use App\Traits\Permissions;
use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;

class Version210 extends Listener
{
    use Permissions;

    const ALIAS = 'calendar';

    const VERSION = '2.1.0';

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
        $this->updateDatabase();
    }

    protected function updatePermissions()
    {
        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-settings' => 'r,u',
        ]);
    }

    protected function updateDatabase()
    {
        setting()->set('calendar.first_day', 0);
        setting()->save();
    }
}
