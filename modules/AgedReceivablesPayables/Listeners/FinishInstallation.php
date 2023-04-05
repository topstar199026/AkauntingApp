<?php

namespace Modules\AgedReceivablesPayables\Listeners;

use App\Events\Module\Installed as Event;
use App\Models\Common\Report;
use App\Traits\Permissions;
use Modules\AgedReceivablesPayables\Reports\AgedPayables;
use Modules\AgedReceivablesPayables\Reports\AgedReceivables;

class FinishInstallation
{
    use Permissions;

    public $alias = 'aged-receivables-payables';

    /**
     * Handle the event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != $this->alias) {
            return;
        }

        $this->seedReports();
        $this->updatePermissions();
    }

    protected function seedReports()
    {
        Report::firstOrCreate([
            'company_id' => company_id(),
            'class' => AgedPayables::class,
        ], [
            'name' => trans('aged-receivables-payables::general.aged-payables'),
            'description' => trans('aged-receivables-payables::general.aged-payables-desc'),
            'settings' => [
                'include_upcoming' => 'yes',
                'as_of' => date('Y-m-d')
            ],
            'created_from' => 'module::seed'
        ]);

        Report::firstOrCreate([
            'company_id' => company_id(),
            'class' => AgedReceivables::class,
        ], [
            'name' => trans('aged-receivables-payables::general.aged-receivables'),
            'description' => trans('aged-receivables-payables::general.aged-receivables-desc'),
            'settings' => [
                'include_upcoming' => 'yes',
                'as_of' => date('Y-m-d')
            ],
            'created_from' => 'module::seed'
        ]);
    }

    protected function updatePermissions()
    {
        //read-aged-receivables-payables-reports-aged-receivables
        // c=create, r=read, u=update, d=delete

    }
}
