<?php

namespace Modules\Projects\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\DB;

class Version4017 extends Listener
{
    const ALIAS = 'projects';

    const VERSION = '4.0.17';

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

        $this->updateProjectsCurrencyCodes();
    }

    public function updateProjectsCurrencyCodes()
    {
        DB::transaction(function () {
            $projects = DB::table('projects')
                            ->where('status', 'inprogress')
                            ->select('id', 'company_id')
                            ->cursor();

            foreach ($projects as $project) {
                $currency_code = 'USD';

                $company_default_currency = DB::table('settings')
                                ->where([
                                    'company_id' => $project->company_id,
                                    'key' => 'default.currency'
                                ])
                                ->first();

                if ($company_default_currency) {
                    $currency_code = $company_default_currency->value;
                }

                DB::table('projects')
                    ->where('id', $project->id)
                    ->update(['currency_code' => $currency_code]);
            }
        });
    }
}
