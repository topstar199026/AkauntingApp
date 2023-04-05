<?php

namespace Modules\Projects\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Projects\Models\Project;

class Projects extends BulkAction
{
    public $model = Project::class;

    public $text = 'projects::general.projects';

    public $path = [
        'group' => 'projects',
        'type' => 'projects',
    ];

    public $actions = [
        'delete' => [
            'icon' => 'delete',
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-projects-projects',
        ],
    ];
}
