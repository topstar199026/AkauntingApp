<?php

namespace Modules\Projects\Widgets\Portal;

use App\Abstracts\Widget;
use App\Traits\DateTime;
use App\Utilities\Date;
use Modules\Projects\Models\Project;

class ProjectBrief extends Widget
{
    use DateTime;

    public $default_name = 'projects::general.widgets.portal.project_brief';

    public $views = [
        'header' => 'projects::widgets.standard_header',
    ];

    public function show($project)
    {
        $date_format = $this->getCompanyDateFormat();
        $defaultDate = new Date("00:00");
        $elapsedDate = new Date("00:00");

        Project::find($project->id)->timesheets()->each(function ($timesheet) use (&$elapsedDate) {
            if ($timesheet->task->is_visible_to_customer == true) {
                date_add($elapsedDate, date_diff(Date::parse($timesheet->started_at), Date::parse($timesheet->ended_at)));
            }
        });

        $total_logged_hours = $defaultDate->diff($elapsedDate)->format('%H:%I');

        return $this->view('projects::widgets.portal.project_brief', compact('project', 'date_format', 'total_logged_hours'));
    }
}
