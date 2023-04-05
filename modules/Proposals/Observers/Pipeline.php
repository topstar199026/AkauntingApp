<?php

namespace Modules\Proposals\Observers;

use App\Abstracts\Observer;
use Modules\Crm\Models\DealPipeline as Model;
use Modules\Proposals\Models\ProposalPipeline;

class Pipeline extends Observer
{
    /**
     * Listen to the created event.
     *
     * @param Model $pipeline
     * @return void
     */
    public function created(Model $pipeline)
    {
        ProposalPipeline::create([
            'company_id' => company_id(),
            'pipeline_id' => $pipeline->id,
        ]);
    }

    /**
     * Listen to the deleted event.
     *
     * @param Model $pipeline
     * @return void
     */
    public function deleted(Model $pipeline)
    {
        $pipeline = ProposalPipeline::where('pipeline_id', $pipeline->id)->first();

        if ($pipeline) {
            ProposalPipeline::where('pipeline_id', $pipeline->id)->delete();
        }
    }
}
