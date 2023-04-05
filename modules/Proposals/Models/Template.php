<?php

namespace Modules\Proposals\Models;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;

class Template extends Model
{
    use Cloneable;
    
    protected $table = 'proposal_templates';

    protected $fillable = ['company_id', 'name', 'description', 'content_html', 'content_css', 'content_components', 'content_style'];

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
            'url' => route('proposals.templates.edit', $this->id),
            'permission' => 'update-proposals-templates',
            'attributes' => [
                'id' => 'index-line-actions-edit-template-' . $this->id,
            ],
        ];

        $actions[] = [
            'title' => trans('general.duplicate'),
            'icon' => 'file_copy',
            'url' => route('proposals.templates.duplicate', $this->id),
            'permission' => 'create-proposals-templates',
            'attributes' => [
                'id' => 'index-line-actions-duplicate-template-' . $this->id,
            ],
        ];

        $actions[] = [
            'title' => trans('general.download'),
            'icon' => 'file_download',
            'url' => route('proposals.templates.download', $this->id),
            'permission' => 'read-proposals-templates',
            'attributes' => [
                'id' => 'index-line-actions-download-template-' . $this->id,
            ],
        ];

        $actions[] = [
            'type' => 'delete',
            'icon' => 'delete',
            'route' => 'proposals.templates.destroy',
            'permission' => 'delete-proposals-templates',
            'model' => $this,
        ];

        return $actions;
    }
}
