<?php

namespace Modules\Projects\Observers;

use App\Abstracts\Observer;
use App\Models\Document\Document as Model;
use App\Traits\Jobs;
use App\Traits\Modules;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Jobs\Activities\CreateActivity;
use Modules\Projects\Jobs\Financials\CreateFinancial;
use Modules\Projects\Jobs\Financials\DeleteFinancial;
use Modules\Projects\Jobs\Financials\UpdateFinancial;
use Modules\Projects\Models\Financial;
use Modules\Projects\Models\Task;

class Document extends Observer
{
    use Jobs, Modules;

    /**
     * Listen to the created event.
     *
     * @param Model $document
     * @return void
     */
    public function created(Model $document)
    {
        if ($this->moduleIsDisabled('projects')) {
            return;
        }

        $request = request();
        $project_id = $this->getProjectId($document, $request);

        if (! $project_id) {
            return;
        }

        $this->dispatch(new CreateActivity([
            'company_id' => company_id(),
            'project_id' => $project_id,
            'activity_id' => $document->id,
            'activity_type' => get_class($document),
            'description' => trans('projects::activities.created.' . $document->type, [
                'user' => auth()->user()->name,
                'number' => $document->document_number
            ]),
            'created_by' => auth()->id()
        ]));

        $request->merge([
            'company_id' => company_id(),
            'project_id' => $project_id,
            'financialable_id' => $document->id,
            'financialable_type' => get_class($document),
        ]);

        $this->dispatch(new CreateFinancial($request));
    }

    /**
     * Listen to the updated event.
     *
     * @param Model $document
     * @return void
     */
    public function updated(Model $document)
    {
        if ($this->moduleIsDisabled('projects')) {
            return;
        }

        $request = request();
        $project_id = $this->getProjectId($document, $request);

        if (! $project_id) {
            return;
        }

        $financial = Financial::where([
            'financialable_id' => $document->id,
            'financialable_type' => get_class($document),
        ])->first();

        if (empty($financial)) {
            $this->created($document);
        } elseif ($financial->project_id != $project_id) {
            $this->dispatch(new UpdateFinancial($financial, ['project_id' => $project_id]));
        }
    }

    /**
     * Listen to the deleted event.
     *
     * @param Model $document
     * @return void
     */
    public function deleted(Model $document)
    {
        if ($this->moduleIsDisabled('projects')) {
            return;
        }

        $financial = Financial::where([
            'financialable_id' => $document->id,
            'financialable_type' => get_class($document),
        ])->first();

        if ($financial) {
            if ($document->type == Model::INVOICE_TYPE) {
                DB::transaction(function () use ($financial, $document) {
                    Task::where([
                        'project_id' => $financial->project_id,
                        'invoice_id' => $document->id,
                    ])->update([
                        'is_invoiced' => false,
                        'invoice_id' => null,
                    ]);
                });
            }

            $this->dispatch(new DeleteFinancial($financial));
        }
    }

    protected function getProjectId($document, $request)
    {
        if (is_null($project_id = $request->project_id)) {
            if ($request->segment(2) == 'projects') {
                $project_id = $request->segment(4);
            } elseif (str($request->getPathInfo())->contains('duplicate')) {
                $document = $request->route($document->type);

                $project_id = Financial::where([
                    'financialable_id' => $document->id,
                    'financialable_type' => get_class($document),
                ])->first()->project_id ?? null;
            }
        }

        return $project_id;
    }
}
