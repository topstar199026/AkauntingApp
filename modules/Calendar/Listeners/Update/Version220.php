<?php

namespace Modules\Calendar\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\File;

class Version220 extends Listener
{
    const ALIAS = 'calendar';

    const VERSION = '2.2.0';

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
        $directories = [
            'Listeners\Updates',
            'Traits',
            'public',
        ];

        foreach ($directories as $directory) {
            File::deleteDirectory(base_path('modules/Calendar/' . $directory));
        }
    }
}
