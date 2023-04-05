<?php

namespace Modules\Projects\Widgets;

use App\Abstracts\Widget;
use Modules\Projects\Models\ProjectUser;

class TotalUser extends Widget
{

    public $default_name = 'projects::general.widgets.total_user';

    public function getDefaultSettings()
    {
        return [
            'width' => 'w-full lg:w-1/4 px-12 my-8',
        ];
    }

    public function show($project = null)
    {
        $userTotal = 0;

        if ($project) {
            $hasProject = true;
            $userTotal = $project->users->count();
            $this->views['header'] = 'projects::widgets.standard_header';
        } else {
            $hasProject = false;
            $userTotal = ProjectUser::where('company_id', company_id())->count();
            $this->views['header'] = 'projects::widgets.stats_header';
        }

        return $this->view('projects::widgets.total_user', [
            'userTotal' => $userTotal,
            'hasProject' => $hasProject,
        ]);
    }
}
