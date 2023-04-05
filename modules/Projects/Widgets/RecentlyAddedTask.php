<?php

namespace Modules\Projects\Widgets;

use App\Abstracts\Widget;
use App\Traits\DateTime;
use Illuminate\Support\Facades\Route;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\Task;

class RecentlyAddedTask extends Widget
{
    use DateTime;

    public $default_name = 'projects::general.widgets.recently_added_task_by_project';

    public $default_settings = [
        'width' => 'w-full lg:w-1/3 px-12 my-8',
    ];

    public function show($project = null)
    {
        if ($project) {
            $this->model->name = trans('projects::general.widgets.recently_added_task');

            $ids = collect($project->id);
        } else {
            $ids = Project::where('company_id', company_id())->pluck('id');
        }

        $model = Task::whereIn('project_id', $ids)
            ->orderBy('created_at', 'desc')
            ->take(5);

        $tasks = $this->applyFilters($model, ['date_field' => 'created_at'])
            ->get()
            ->map(function ($task) {
                $task->at = company_date($task->created_at);

                return $task;
            });

        if (Route::is('projects.projects.show')) {
            $this->views = ['header' => 'projects::widgets.empty_header'];
        }

        return $this->view('projects::widgets.recently_added_task', [
            'tasks' => $tasks,
        ]);
    }
}
