<?php

namespace Modules\Proposals\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Proposals\Models\Template;

class Templates extends BulkAction
{
    public $model = Template::class;

    public $text = 'general.templates';

    public $path = [
        'group' => 'proposals',
        'type' => 'templates',
    ];

    public $actions = [
        'duplicate' => [
            'name' => 'general.duplicate',
            'message' => 'bulk_actions.message.duplicate',
            'path' =>  ['group' => 'proposals', 'type' => 'templates'],
            'type' => '*',
            'permission' => 'create-proposals-templates',
        ],
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'path' =>  ['group' => 'proposals', 'type' => 'templates'],
            'type' => '*',
            'permission' => 'delete-proposals-templates',
        ],
    ];
}