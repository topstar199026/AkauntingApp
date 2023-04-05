<?php

namespace Modules\Projects\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Projects\Jobs\Milestones\DeleteMilestone;
use Modules\Projects\Models\Milestone;

class Milestones extends BulkAction
{
    public $model = Milestone::class;

    public $text = 'projects::general.milestones';

    public $path = [
        'group' => 'projects',
        'type' => 'milestones',
    ];

    public $actions = [
        'delete' => [
            'icon' => 'delete',
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-projects-milestones',
        ],
    ];

    public function destroy($request)
    {
        $this->deleteMilestones($request);
    }

    public function deleteMilestones($request)
    {
        $milestones = $this->getSelectedRecords($request);

        foreach ($milestones as $milestone) {
            try {
                $this->dispatch(new DeleteMilestone($milestone));
            } catch (\Exception$e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }
}
