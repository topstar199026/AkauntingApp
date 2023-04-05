<?php

namespace Modules\Proposals\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\Artisan;

class Version205 extends Listener
{
    const ALIAS = 'proposals';

    const VERSION = '2.0.5';

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

        Artisan::call('migrate', ['--force' => true]);
    }
}
