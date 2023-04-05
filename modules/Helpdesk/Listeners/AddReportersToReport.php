<?php

namespace Modules\Helpdesk\Listeners;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterApplying;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupApplying;
use App\Events\Report\GroupShowing;
use App\Events\Report\RowsShowing;
use App\Models\Auth\User;

class AddReportersToReport extends Listener
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

        $event->class->filters['reporters'] = $this->getReporters(true);
        $event->class->filters['routes']['reporters'] = 'users.index';
        $event->class->filters['names']['reporters'] = trans_choice('helpdesk::general.reporters', 1);
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

        $reporter_id = $this->getSearchStringValue('reporter_id');

        if (empty($reporter_id)) {
            return;
        }

        $event->model->where('created_by', $reporter_id);
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

        $event->class->groups['reporter'] = trans_choice('helpdesk::general.reporters', 1);
    }

    /**
     * Handle group applying event.
     *
     * @param  $event
     * @return void
     */
    public function handleGroupApplying(GroupApplying $event)
    {
        if ($this->skipThisClass($event)) {
            return;
        }

        $event->model->reporter_id = $event->model->created_by;
    }

    /**
     * Handle rows showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'reporter')) {
            return;
        }

        $all_reporters = $this->getReporters();

        if ($reporter_ids = $this->getSearchStringValue('reporter_id')) {
            $reporters = explode(',', $reporter_ids);

            $rows = collect($all_reporters)->filter(function ($value, $key) use ($reporters) {
                return in_array($key, $reporters);
            });
        } else {
            $rows = $all_reporters;
        }

        $this->setRowNamesAndValues($event, $rows);
    }

    public function getReporters($limit = false)
    {
        $model = User::whereHas('helpdesk_tickets_reporter');

        if ($limit !== false) {
            $model->take(setting('default.select_limit'));
        }

        return $model->pluck('name', 'id')->toArray();
    }
}
