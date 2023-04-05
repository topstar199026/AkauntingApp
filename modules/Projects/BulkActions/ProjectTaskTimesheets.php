<?php

namespace Modules\Projects\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Projects\Jobs\ProjectTaskTimesheets\DeleteProjectTaskTimesheet;
use Modules\Projects\Models\ProjectTaskTimesheet;

class ProjectTaskTimesheets extends BulkAction
{
    public $model = ProjectTaskTimesheet::class;

    public $text = 'projects::general.timesheets';

    public $path = [
        'group' => 'projects',
        'type' => 'project-task-timesheets',
    ];

    public $actions = [
        'delete' => [
            'icon' => 'delete',
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-projects-timesheets',
        ],
    ];

    public function destroy($request)
    {
        $this->deleteTimesheets($request);
    }

    public function deleteTimesheets($request)
    {
        $timesheets = $this->getSelectedRecords($request);

        foreach ($timesheets as $timesheet) {
            try {
                $this->dispatch(new DeleteProjectTaskTimesheet($timesheet));
            } catch (\Exception$e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }
}
