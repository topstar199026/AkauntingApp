<?php

namespace Modules\Projects\Observers;

use App\Abstracts\Observer;
use App\Models\Banking\Transaction as Model;
use App\Traits\Jobs;
use App\Traits\Modules;
use Modules\Projects\Jobs\Activities\CreateActivity;
use Modules\Projects\Jobs\Financials\CreateFinancial;
use Modules\Projects\Jobs\Financials\DeleteFinancial;
use Modules\Projects\Jobs\Financials\UpdateFinancial;
use Modules\Projects\Models\Financial;

class Transaction extends Observer
{
    use Jobs, Modules;

    /**
     * Listen to the created event.
     *
     * @param Model $transaction
     * @return void
     */
    public function created(Model $transaction)
    {
        if ($this->moduleIsDisabled('projects')) {
            return;
        }

        $request = request();
        $project_id = $this->getProjectId($request);

        if (! $project_id) {
            return;
        }

        $this->dispatch(new CreateActivity([
            'company_id' => company_id(),
            'project_id' => $project_id,
            'activity_id' => $transaction->id,
            'activity_type' => get_class($transaction),
            'description' => trans('projects::activities.created.' . $transaction->type, [
                'user' => auth()->user()->name,
                'number' => $transaction->number
            ]),
            'created_by' => auth()->id()
        ]));

        $request->merge([
            'company_id' => company_id(),
            'financialable_id' => $transaction->id,
            'financialable_type' => get_class($transaction),
        ]);

        $this->dispatch(new CreateFinancial($request));
    }

    /**
     * Listen to the updated event.
     *
     * @param Model $transaction
     * @return void
     */
    public function updated(Model $transaction)
    {
        if ($this->moduleIsDisabled('projects')) {
            return;
        }

        $request = request();
        $project_id = $this->getProjectId($request);

        if (! $project_id) {
            return;
        }

        $financial = Financial::where([
            'financialable_id' => $transaction->id,
            'financialable_type' => get_class($transaction),
        ])->first();

        if ($financial && $financial->project_id != $project_id) {
            $this->dispatch(new UpdateFinancial($financial, ['project_id' => $project_id]));

            return;
        }

        $request->merge([
            'company_id' => company_id(),
            'financialable_id' => $transaction->id,
            'financialable_type' => get_class($transaction),
        ]);

        $this->dispatch(new CreateFinancial($request));
    }

    /**
     * Listen to the deleted event.
     *
     * @param Model $transaction
     * @return void
     */
    public function deleted(Model $transaction)
    {
        if ($this->moduleIsDisabled('projects')) {
            return;
        }

        $financial = Financial::where([
            'financialable_id' => $transaction->id,
            'financialable_type' => get_class($transaction),
        ])->first();

        if ($financial) {
            $this->dispatch(new DeleteFinancial($financial));
        }
    }

    protected function getProjectId($request)
    {
        $project_id = $request->project_id;

        if (is_null($request->project_id) && $request->segment(2) == 'projects') {
            $project_id = $request->segment(4);
        }

        return $project_id;
    }
}
