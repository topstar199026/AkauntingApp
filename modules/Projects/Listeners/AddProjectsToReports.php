<?php

namespace Modules\Projects\Listeners;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterApplying;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupApplying;
use App\Events\Report\GroupShowing;
use App\Events\Report\RowsShowing;
use Modules\Projects\Models\Project;

class AddProjectsToReports extends Listener
{
    protected $classes = [
        'App\Reports\IncomeSummary',
        'App\Reports\ExpenseSummary',
        'App\Reports\IncomeExpenseSummary',
        'App\Reports\ProfitLoss',
    ];

    /**
     * Handle filter showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterShowing(FilterShowing $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $event->class->filters['projects'] = $this->getProjects(true);
        $event->class->filters['routes']['projects'] = 'projects.projects.index';
        $event->class->filters['names']['projects'] = trans_choice('projects::general.projects', 1);
    }

    /**
     * Handle filter applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleFilterApplying(FilterApplying $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }
        
        $project_id = $this->getSearchStringValue('project_id');

        $projects = empty($project_id) ? array_keys($event->class->filters['projects']) : [$project_id];

        if (empty($projects)) {
            return;
        }

        $event->model->whereHas('project', function ($query) use ($projects, $event) {
            $query->whereIn('project_id', $projects);
        });
    }

    /**
     * Handle group showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleGroupShowing(GroupShowing $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $event->class->groups['project'] = trans_choice('projects::general.projects', 1);
    }

    /**
     * Handle group applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleGroupApplying(GroupApplying $event)
    {
        $report = $event->class;

        if ($report->getSetting('group') != 'project') {
            return;
        }

        if ($this->skipThisClass($event)) {
            return;
        }

        if (get_class($event->model) == 'Modules\DoubleEntry\Models\Journal') {
            return;
        }

        $event->model->project_id = $event->model->project->project_id;
    }

    /**
     * Handle rows showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'project')) {
            return;
        }

        $project_id = $this->getSearchStringValue('project_id');

        $projects = ! empty($project_id)
                    ? [$project_id => $event->class->filters['projects'][$project_id]]
                    : $event->class->filters['projects'];

        if (empty($projects)) {
            return;
        }

        $this->setRowNamesAndValues($event, $projects);
    }

    public function skipThisClass($event)
    {
        $names = [
            trans('projects::general.reports.name.income_summary'),
            trans('projects::general.reports.name.expense_summary'),
            trans('projects::general.reports.name.income_expense'),
            trans('projects::general.reports.name.profit_loss'),
        ];

        $condition = empty($event->class) || ! in_array(get_class($event->class), $this->classes);

        if ($condition === false) {
            $condition = empty($event->class->model->created_from) ? false : ! str($event->class->model->created_from)->contains('projects');
        }

        if ($condition === false) {
            $condition = empty($event->class->model->name) ? false : ! in_array($event->class->model->name, $names);
        }

        return $condition;
    }

    public function getProjects($limit = false)
    {
        $model = Project::orderBy('name');

        if ($limit !== false) {
            $model->take(setting('default.select_limit'));
        }

        return $model->pluck('name', 'id')->toArray();
    }
}
