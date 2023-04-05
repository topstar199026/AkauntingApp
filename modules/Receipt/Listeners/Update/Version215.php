<?php

namespace Modules\Receipt\Listeners\Update;

use App\Events\Install\UpdateFinished;
use App\Abstracts\Listeners\Update as Listener;

class Version215 extends Listener
{
    const ALIAS = 'receipt';

    const VERSION = '2.1.5';

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

        $this->updateSetting();
    }

    public function updateSetting()
    {
        setting()->set('receipt.platform', 'taggun');
        setting()->save();
    }
}
