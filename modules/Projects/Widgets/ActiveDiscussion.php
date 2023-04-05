<?php

namespace Modules\Projects\Widgets;

use App\Abstracts\Widget;
use Illuminate\Support\Facades\Route;
use Modules\Projects\Models\Discussion;
use Modules\Projects\Models\Project;

class ActiveDiscussion extends Widget
{
    public $default_name = 'projects::general.widgets.active_discussion_by_project';

    public $default_settings = [
        'width' => 'w-full lg:w-1/3 px-12 my-8',
    ];

    public function show($project = null)
    {
        if ($project) {
            $this->model->name = trans('projects::general.widgets.active_discussion');

            $ids = collect($project->id);
        } else {
            $ids = Project::where('company_id', company_id())->pluck('id');
        }

        $model = Discussion::whereIn('project_id', $ids)
            ->latest()
            ->take(5);

        $discussions = $this->applyFilters($model, ['date_field' => 'created_at'])
            ->get();

        if (Route::is('projects.projects.show', 'portal.projects.projects.show')) {
            $this->views = ['header' => 'projects::widgets.empty_header'];
        }

        return $this->view('projects::widgets.active_discussion', [
            'discussions' => $discussions,
        ]);
    }
}
