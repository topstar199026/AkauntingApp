<?php

namespace Modules\Proposals\Models;

use App\Abstracts\Model;
use App\Traits\Modules;
use Bkwld\Cloner\Cloneable;

class Proposal extends Model
{
    use Cloneable, Modules;

    protected $table = 'proposals';

    protected $fillable = ['company_id', 'estimates_id', 'deal_id', 'template_id', 'description', 'content_html', 'content_css', 'content_components', 'content_style'];
    
    public function estimate()
    {
        return $this->belongsTo('Modules\Estimates\Models\Estimate', 'estimates_id', 'id');
    }
    
    public function pipeline()
    {
        return $this->belongsTo('Modules\Crm\Models\DealPipeline', 'pipeline_id', 'id');
    }
    
    public function deal()
    {
        return $this->belongsTo('Modules\Crm\Models\Deal', 'deal_id', 'id');
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        $module_estimates = $this->moduleIsEnabled('estimates');
        $module_crm = $this->moduleIsEnabled('crm');

        $is_customer = user()->isCustomer();

        if (! $is_customer) {
            $actions[] = [
                'title' => trans('general.edit'),
                'icon' => 'edit',
                'url' => route('proposals.proposals.edit', $this->id),
                'permission' => 'update-proposals-proposals',
                'attributes' => [
                    'id' => 'index-line-actions-edit-proposal-' . $this->id,
                ],
            ];

            $actions[] = [
                'title' => trans('general.duplicate'),
                'icon' => 'file_copy',
                'url' => route('proposals.proposals.duplicate', $this->id),
                'permission' => 'create-proposals-proposals',
                'attributes' => [
                    'id' => 'index-line-actions-duplicate-proposal-' . $this->id,
                ],
            ];

            $actions[] = [
                'title' => trans('general.download'),
                'icon' => 'file_download',
                'url' => route('proposals.proposals.download', $this->id),
                'permission' => 'read-proposals-proposals',
                'attributes' => [
                    'id' => 'index-line-actions-download-proposal-' . $this->id,
                ],
            ];

            if (($module_estimates && $this->estimate) || ($module_crm && $this->deal)) {
                $actions[] = [
                    'title' => trans('general.send') . ' ' . trans('general.email'),
                    'icon' => 'send',
                    'url' => route('proposals.proposals.notify', $this->id),
                    'permission' => 'read-proposals-proposals',
                    'attributes' => [
                        'id' => 'index-line-actions-send-proposal-' . $this->id,
                    ],
                ];
            }

            $actions[] = [
                'type' => 'delete',
                'icon' => 'delete',
                'route' => 'proposals.proposals.destroy',
                'permission' => 'delete-proposals-proposals',
                'model' => $this,
            ];
        }

        if ($is_customer) {
            $actions[] = [
                'title' => trans('general.show'),
                'icon' => 'visibility',
                'url' => route('portal.proposals.proposals.show', $this->id),
                'permission' => 'read-proposals-portal-proposals',
                'attributes' => [
                    'id' => 'index-line-actions-portal-show-proposal-' . $this->id,
                ],
            ];

            $actions[] = [
                'title' => trans('general.download'),
                'icon' => 'picture_as_pdf',
                'url' => route('portal.proposals.proposals.download', $this->id),
                'permission' => 'read-proposals-portal-proposals',
                'attributes' => [
                    'id' => 'index-line-actions-portal-download-proposal-' . $this->id,
                ],
            ];

            if (($module_estimates && $this->estimate()->first()) || ($module_crm && $this->deal()->first())) {
                $actions[] = [
                    'title' => trans('proposals::general.approve'),
                    'icon' => 'thumb_up_alt',
                    'url' => route('portal.proposals.proposals.approve', $this->id),
                    'permission' => 'read-proposals-portal-proposals',
                    'attributes' => [
                        'id' => 'index-line-actions-portal-approve-proposal-' . $this->id,
                    ],
                ];

                $actions[] = [
                    'title' => trans('proposals::general.refuse'),
                    'icon' => 'thumb_down_alt',
                    'url' => route('portal.proposals.proposals.refuse', $this->id),
                    'permission' => 'read-proposals-portal-proposals',
                    'attributes' => [
                        'id' => 'index-line-actions-portal-send-proposal-' . $this->id,
                    ],
                ];
            }
        }

        return $actions;
    }
}
