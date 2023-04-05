<?php

namespace Modules\Helpdesk\Listeners;

use App\Events\Module\Uninstalled as Event;
use App\Traits\Jobs;

class FinishUninstallation
{
    use Jobs;

    public $alias = 'helpdesk';

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != $this->alias) {
            return;
        }

        // Code to run on uninstallation here
    }

}
