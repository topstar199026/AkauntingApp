<?php

namespace Modules\Proposals\Models;

use App\Abstracts\Model;
use Modules\Crm\Models\DealPipeline;

class ProposalPipeline extends Model
{
    protected $table = 'proposal_pipelines';

    protected $fillable = ['company_id', 'pipeline_id', 'stage_id_create', 'stage_id_send', 'stage_id_approve', 'stage_id_refused'];

    /**
     * Get the pipeline associated with the proposal.
     */
    public function pipeline()
    {
        return $this->belongsTo(DealPipeline::class);
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        $actions[] = [
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'url' => route('proposals.pipelines.edit', $this->id),
            'permission' => 'update-proposals-pipelines',
            'attributes' => [
                'id' => 'index-line-actions-edit-pipeline-' . $this->id,
            ],
        ];

        return $actions;
    }
}
