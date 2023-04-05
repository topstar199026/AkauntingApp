<?php

namespace Modules\Helpdesk\Listeners;

use App\Abstracts\Listeners\Report as Listener;
use App\Events\Report\FilterApplying;
use App\Events\Report\FilterShowing;
use App\Events\Report\GroupShowing;
use App\Events\Report\RowsShowing;

class AddCategoriesToReport extends Listener
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

        $event->class->filters['categories'] = $this->getCategories('ticket', true);
        $event->class->filters['routes']['categories'] = ['categories.index', 'search=type:ticket'];
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

        $category_id = $this->getSearchStringValue('category_id');

        if (empty($category_id)) {
            return;
        }

        $event->model->where('category_id', $category_id);
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

        $event->class->groups['category'] = trans_choice('general.categories', 1);
    }

    /**
     * Handle rows showing event.
     *
     * @param  $event
     * @return void
     */
    public function handleRowsShowing(RowsShowing $event)
    {
        if ($this->skipRowsShowing($event, 'category')) {
            return;
        }

        $all_categories = $this->getCategories('ticket');

        if ($category_ids = $this->getSearchStringValue('category_id')) {
            $categories = explode(',', $category_ids);

            $rows = collect($all_categories)->filter(function ($value, $key) use ($categories) {
                return in_array($key, $categories);
            });
        } else {
            $rows = $all_categories;
        }

        $this->setRowNamesAndValues($event, $rows);

        $event->class->row_tree_nodes = [];

        $nodes = $this->getCategoriesNodes($rows);

        $this->setTreeNodes($event, $nodes);
    }
}
