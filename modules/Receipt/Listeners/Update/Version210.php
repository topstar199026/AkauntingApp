<?php

namespace Modules\Receipt\Listeners\Update;

use App\Events\Install\UpdateFinished;
use App\Abstracts\Listeners\Update as Listener;
use Illuminate\Support\Facades\Artisan;
use Modules\Receipt\Models\Receipt;

class Version210 extends Listener
{
    const ALIAS = 'receipt';

    const VERSION = '2.1.0';

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

        $this->updateMigration();
        $this->updateReceipt();
    }

    public function updateMigration()
    {
        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);
    }

    public function updateReceipt()
    {
        $receipts = Receipt::all();

        foreach ($receipts as $receipt) {
            $receipt->currency_code = setting('default.currency');
            $receipt->update();
        }
    }
}
