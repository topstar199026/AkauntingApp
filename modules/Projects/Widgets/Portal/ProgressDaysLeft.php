<?php

namespace Modules\Projects\Widgets\Portal;

use App\Abstracts\Widget;
use App\Utilities\Date;

class ProgressDaysLeft extends Widget
{
    public $views = [
        'header' => 'projects::widgets.standard_header',
    ];

    public function show($project)
    {
        $total_days = Date::parse($project->started_at)->diffInDays(Date::parse($project->ended_at));
        $passed_days = Date::parse($project->started_at)->diffInDays(Date::now());

        if ($passed_days > $total_days) {
            $passed_days = $total_days;
        }

        $this->model->name = $passed_days . ' / ' . $total_days . ' ' . trans('projects::general.widgets.portal.progress_days_left');

        return $this->view('projects::widgets.portal.progress', [
            'total' => $total_days,
            'total_text' => trans('projects::general.widgets.total_days'),
            'percentage' => $total_days == 0 ? 0 : round($passed_days / $total_days * 100),
        ]);
    }
}
