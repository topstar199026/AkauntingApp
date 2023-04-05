<?php
namespace Modules\Proposals\Listeners;

use App\Events\Module\Installed as Event;
use Illuminate\Support\Facades\Artisan;

class InstallModule
{
    /**
     * Handle the event.
     *
     * @param  Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != 'proposals') {
            return;
        }

        $this->callSeeds();
    }

    protected function callSeeds()
    {
        Artisan::call('company:seed', [
            'company' => company_id(),
            '--class' => 'Modules\Proposals\Database\Seeds\Install',
        ]);
    }
}