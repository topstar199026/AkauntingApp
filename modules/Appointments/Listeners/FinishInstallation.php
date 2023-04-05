<?php

namespace Modules\Appointments\Listeners;

use App\Traits\Permissions;
use Illuminate\Support\Facades\Artisan;
use App\Events\Module\Installed as Event;

class FinishInstallation
{
    use Permissions;

    public $alias = 'appointments';

    /**
     * Handle the event.
     *
     * @param  Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != $this->alias) {
            return;
        }

        $this->callSeeds();
    }

    protected function callSeeds()
    {
        Artisan::call('company:seed', [
            'company' => company_id(),
            '--class' => 'Modules\Appointments\Database\Seeds\Install',
        ]);
    }
}
