<?php

namespace Modules\Helpdesk\Listeners\Update\V10;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Interfaces\Listener\ShouldUpdateAllCompanies;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Version105 extends Listener implements ShouldUpdateAllCompanies
{
    const ALIAS = 'helpdesk';

    const VERSION = '1.0.5';

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

        $this->updateDatabase();
        $this->updateSettings();
    }

    protected function updateDatabase()
    {
        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);

        $tickets = DB::table('helpdesk_tickets')->whereNull('name')->cursor();
        foreach ($tickets as $ticket) {
            DB::table('helpdesk_tickets')
                ->where('id', $ticket->id)
                ->update(['name' => str_pad($ticket->id, 10, '0', STR_PAD_LEFT)]);
        }
    }

    protected function updateSettings()
    {
        if (setting('helpdesk.tickets.next') == null) {
            $company_id = company_id();
            $ticket = DB::table('helpdesk_tickets')
                ->where('company_id', $company_id)
                ->orderBy('id', 'desc')
                ->first();

            setting([
                'helpdesk.tickets.next' => $ticket ? $ticket->id + 1 : 1
            ])->save();
        }
    }
}
