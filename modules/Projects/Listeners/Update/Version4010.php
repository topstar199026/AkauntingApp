<?php

namespace Modules\Projects\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\File;

class Version4010 extends Listener
{
    const ALIAS = 'projects';

    const VERSION = '4.0.10';

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
        $files = [
            'Models/ProjectBill.php',
            'Models/ProjectInvoice.php',
            'Models/ProjectPayment.php',
            'Models/ProjectRevenue.php',
            'Traits/Discussions.php',
            'Traits/Projects.php',
            'Traits/Tasks.php',
        ];

        foreach ($files as $file) {
            File::delete(module_path(self::ALIAS, $file));
        }

        File::deleteDirectory(module_path(self::ALIAS, 'Resources/assets/js/components'));
    }
}
