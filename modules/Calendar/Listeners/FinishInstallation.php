<?php

namespace Modules\Calendar\Listeners;

use App\Events\Module\Installed as Event;
use App\Models\Auth\Permission;
use App\Traits\Permissions;
use App\Models\Auth\Role;
use Artisan;

class FinishInstallation
{
    use Permissions;

    public $alias = 'calendar';

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != 'calendar') {
            return;
        }

        $this->callSeeds();
    }

    protected function callSeeds()
    {
        Artisan::call('company:seed', [
            'company' => company_id(),
            '--class' => 'Modules\Calendar\Database\Seeds\Install',
        ]);
    }
}
