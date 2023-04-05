<?php

namespace Modules\Projects\Widgets;

use App\Abstracts\Widget;
use Modules\Projects\Models\Activity;

class TotalActivity extends Widget
{

    public $default_name = 'projects::general.widgets.total_activity';

    public function getDefaultSettings()
    {
        return [
            'width' => 'w-full lg:w-1/4 px-12 my-8',
        ];
    }

    public function show($project = null)
    {
        $activityTotal = 0;

        if ($project) {
            $hasProject = true;
            $activityTotal = $project->activities->count();
            $this->views['header'] = 'projects::widgets.standard_header';
        } else {
            $hasProject = false;
            $activityTotal = Activity::where('company_id', company_id())->count();
            $this->views['header'] = 'projects::widgets.stats_header';
        }

        return $this->view('projects::widgets.total_activity', [
            'activityTotal' => $activityTotal,
            'hasProject' => $hasProject,
        ]);
    }
}
