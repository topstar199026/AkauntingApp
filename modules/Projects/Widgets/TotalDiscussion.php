<?php

namespace Modules\Projects\Widgets;

use App\Abstracts\Widget;
use Modules\Projects\Models\Discussion;

class TotalDiscussion extends Widget
{

    public $default_name = 'projects::general.widgets.total_discussion';

    public function getDefaultSettings()
    {
        return [
            'width' => 'w-full lg:w-1/4 px-12 my-8',
        ];
    }

    public function show($project = null)
    {
        $discussionTotal = 0;

        if ($project) {
            $hasProject = true;
            $discussionTotal = $project->discussions->count();
            $this->views['header'] = 'projects::widgets.standard_header';
        } else {
            $hasProject = false;
            $discussionTotal = Discussion::where('company_id', company_id())->count();
            $this->views['header'] = 'projects::widgets.stats_header';
        }

        return $this->view('projects::widgets.total_discussion', [
            'discussionTotal' => $discussionTotal,
            'hasProject' => $hasProject,
        ]);
    }
}
