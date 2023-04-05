<?php

namespace Modules\Calendar\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Interfaces\Listener\ShouldUpdateAllCompanies;
use Illuminate\Support\Facades\File;

class Version221 extends Listener implements ShouldUpdateAllCompanies
{
    const ALIAS = 'calendar';

    const VERSION = '2.2.1';

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

        $this->settingUpdate();

        $this->deleteOldFiles();
    }

    protected function settingUpdate()
    {
        setting()->forget('calendar.countries');
        setting()->save();
    }

    protected function deleteOldFiles()
    {
        $files = [
            'Resources/lang/en-GB/countries.php'
        ];

        $directories = [
            'vendor/azuyalabs',
        ];

        foreach ($files as $file) {
            File::delete(base_path('modules/Calendar/' . $file));
        }

        foreach ($directories as $directory) {
            File::deleteDirectory(base_path('modules/Calendar/' . $directory));
        }
    }
}