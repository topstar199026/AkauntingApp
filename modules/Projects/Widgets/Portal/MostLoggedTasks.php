<?php

namespace Modules\Projects\Widgets\Portal;

use App\Abstracts\Widget;
use App\Traits\DateTime;
use App\Utilities\Date;
use Modules\Projects\Models\Project;

class MostLoggedTasks extends Widget
{
    use DateTime;

    public $default_name = 'projects::general.widgets.portal.most_logged_tasks';

    public $views = [
        'header' => 'projects::widgets.standard_header',
    ];

    public function show($project)
    {
        $defaultDate = new Date("00:00");

        $tasks = Project::find($project->id)->tasks->reject(function ($task) {
            return $task->is_visible_to_customer == false;
        })->each(function ($task) use (&$defaultDate) {
            if ($task->is_visible_to_customer == true) {
                $elapsedDate = new Date("00:00");

                $task->timesheets()->each(function ($timesheet) use (&$elapsedDate) {
                    date_add($elapsedDate, date_diff(Date::parse($timesheet->started_at), Date::parse($timesheet->ended_at)));
                });

                $task->logged_time = $defaultDate->diff($elapsedDate)->format('%H:%I');
            }
        })->sortByDesc('logged_time')->take(5);

        return $this->view('projects::widgets.portal.most_logged_tasks', compact('project', 'tasks'));
    }
}
