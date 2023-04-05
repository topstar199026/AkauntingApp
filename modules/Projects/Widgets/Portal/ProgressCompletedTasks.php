<?php

namespace Modules\Projects\Widgets\Portal;

use App\Abstracts\Widget;
use Modules\Projects\Models\Task;

class ProgressCompletedTasks extends Widget
{
    public $views = [
        'header' => 'projects::widgets.standard_header',
    ];

    public function show($project)
    {
        $tasks = Task::where('project_id', $project->id)->visibleToCustomer()->get();
        $completed_tasks = Task::where(['project_id' => $project->id, 'status' => 'complated'])->visibleToCustomer()->get();

        $this->model->name =  $completed_tasks->count() . ' / ' . $tasks->count() . ' ' . trans('projects::general.widgets.portal.progress_completed_tasks');

        return $this->view('projects::widgets.portal.progress', [
            'total' => $tasks->count(),
            'total_text' => trans('projects::general.widgets.total_task'),
            'percentage' => $tasks->count() == 0 ? 0 : round($completed_tasks->count() / $tasks->count() * 100),
        ]);
    }
}
