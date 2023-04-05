<?php

namespace Modules\Helpdesk\Listeners;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterApplying;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupShowing;
use App\Events\Report\RowsShowing;
use Modules\Helpdesk\Models\Status;

class AddStatusesToReport extends Listener
{
    protected $classes = [
        'Modules\Helpdesk\Reports\TicketSummary',
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

        $event->class->filters['statuses'] = $this->getStatuses(true);
        $event->class->filters['routes']['statuses'] = 'helpdesk.statuses.index';
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

        $status_id = $this->getSearchStringValue('status_id');

        if (empty($status_id)) {
            return;
        }

        $event->model->where('status_id', $status_id);
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

        $event->class->groups['status'] = trans_choice('helpdesk::general.statuses', 1);
    }

    /**
     * Handle rows showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'status')) {
            return;
        }

        $all_statuses = $this->getStatuses();

        if ($status_ids = $this->getSearchStringValue('status_id')) {
            $statuses = explode(',', $status_ids);

            $rows = collect($all_statuses)->filter(function ($value, $key) use ($statuses) {
                return in_array($key, $statuses);
            });
        } else {
            $rows = $all_statuses;
        }

        $this->setRowNamesAndValues($event, $rows);
    }

    public function getStatuses($limit = false)
    {
        $model = Status::all();

        if ($limit !== false) {
            $model->take(setting('default.select_limit'));
        }

        return $model->pluck('name', 'id')->toArray();
    }
}
