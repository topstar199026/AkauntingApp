<?php

namespace Modules\Proposals\Observers;

use App\Abstracts\Observer;
use Modules\Crm\Models\Deal as Model;
use Modules\Proposals\Models\ProposalPipeline;

class Deal extends Observer
{
    /**
     * Listen to the created event.
     *
     * @param Model $deal
     * @return void
     */
    public function created(Model $deal)
    {
        $stage = ProposalPipeline::companyId($deal->company_id)->where('pipeline_id', $deal->pipeline_id)->first()->stage_id_create;

        if ($stage != null) {
            $deal->stage_id = $stage;
        }

        $deal->save();
    }
}
