<?php

namespace Modules\Leaves\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class Version200 extends Listener
{
    const ALIAS = 'leaves';

    const VERSION = '2.0.0';

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

        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);

        $this->deleteOldFilesFolders();
    }

    public function deleteOldFilesFolders()
    {
        $files = [
            'Listeners/ShowInSettingsPage.php',
            'Http/Controllers/Settings/Settings.php',
            'Resources/views/settings/edit.blade.php',
        ];

        foreach ($files as $file) {
            File::delete(base_path('modules/Leaves/' . $file));
        }
    }
}
