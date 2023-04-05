<?php

namespace Modules\Proposals\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Proposals\Models\Proposal;

class Proposals extends BulkAction
{
    public $model = Proposal::class;

    public $text = 'proposals::general.proposals';

    public $path = [
        'group' => 'proposals',
        'type' => 'proposals',
    ];

    public $actions = [
        'duplicate' => [
            'name' => 'general.duplicate',
            'message' => 'bulk_actions.message.duplicate',
            'path' =>  ['group' => 'proposals', 'type' => 'proposals'],
            'type' => '*',
            'permission' => 'create-proposals-proposals',
        ],
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'path' =>  ['group' => 'proposals', 'type' => 'proposals'],
            'type' => '*',
            'permission' => 'delete-proposals-proposals',
        ],
    ];
}
