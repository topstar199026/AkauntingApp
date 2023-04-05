<?php

namespace Modules\Calendar\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\File;

class Version300 extends Listener
{
    const ALIAS = 'calendar';

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

        $this->deleteOldFiles();
    }

    protected function deleteOldFiles()
    {
        File::delete(base_path('modules/Calendar/Listeners/ShowInSettingsPage.php'));
    }
}
