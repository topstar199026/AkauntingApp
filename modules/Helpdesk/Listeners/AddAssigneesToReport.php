<?php

namespace Modules\Helpdesk\Listeners;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterApplying;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupShowing;
use App\Events\Report\RowsShowing;
use App\Models\Auth\User;

class AddAssigneesToReport extends Listener
{
    protected $classes = [
        'Modules\Helpdesk\Reports\TicketSummary'
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

        $event->class->filters['assignees'] = $this->getAssignees(true);
        $event->class->filters['routes']['assignees'] = 'users.index';
        $event->class->filters['names']['assignees'] = trans_choice('helpdesk::general.assignees', 1);
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

        $assignee_id = $this->getSearchStringValue('assignee_id');

        if (empty($assignee_id)) {
            return;
        }

        $event->model->where('assignee_id', $assignee_id);
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

        $event->class->groups['assignee'] = trans_choice('helpdesk::general.assignees', 1);
    }

    /**
     * Handle rows showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'assignee')) {
            return;
        }

        $all_assignees = $this->getAssignees();

        if ($assignee_ids = $this->getSearchStringValue('assignee_id')) {
            $assignees = explode(',', $assignee_ids);

            $rows = collect($all_assignees)->filter(function ($value, $key) use ($assignees) {
                return in_array($key, $assignees);
            });
        } else {
            $rows = $all_assignees;
        }

        $this->setRowNamesAndValues($event, $rows);
    }

    public function getAssignees($limit = false)
    {
        $model = User::whereHas('helpdesk_tickets_assignee');

        if ($limit !== false) {
            $model->take(setting('default.select_limit'));
        }

        return $model->pluck('name', 'id')->toArray();
    }
}
