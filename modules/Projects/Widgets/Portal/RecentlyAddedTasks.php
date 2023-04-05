<?php

namespace Modules\Projects\Widgets\Portal;

use App\Abstracts\Widget;
use App\Traits\DateTime;
use Modules\Projects\Models\Task;

class RecentlyAddedTasks extends Widget
{
    use DateTime;

    public $default_name = 'projects::general.widgets.recently_added_task_by_project';

    public $views = [
        'header' => 'projects::widgets.standard_header',
    ];

    public function show($project)
    {
        $this->model->name = trans('projects::general.widgets.recently_added_task');

        $tasks = $this->applyFilters(Task::where('project_id', $project->id)->visibleToCustomer()->orderBy('created_at', 'desc')
                ->take(5))
            ->get();

        return $this->view('projects::widgets.recently_added_task', [
            'tasks' => $tasks,
            'project' => $project,
            'date_format' => $this->getCompanyDateFormat(),
        ]);
    }
}
