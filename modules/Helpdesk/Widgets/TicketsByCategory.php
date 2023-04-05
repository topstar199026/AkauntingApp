<?php

namespace Modules\Helpdesk\Widgets;

use App\Abstracts\Widget;
use App\Models\Setting\Category;

class TicketsByCategory extends Widget
{
    public $default_name = 'helpdesk::widgets.tickets_by_category';

    public $description = 'helpdesk::widgets.description.tickets_by_category';

    public function show()
    {
        $query = Category::withCount('helpdesk_tickets')->type('ticket')->orderBy('helpdesk_tickets_count', 'desc');

        $query->whereHas('helpdesk_tickets', function ($query) {
            $this->applyFilters($query, ['date_field' => 'created_at']);
        })->each(function ($category) {
            $c = $category->toArray();
            $this->addToDonut($category->color, $category->name, $category->helpdesk_tickets_count);
        });

        $chart = $this->getDonutChart(trans('helpdesk::widgets.tickets_by_category'), '100%', 300, 6);

        return $this->view('widgets.donut_chart', [
            'chart' => $chart,
        ]);
    }
}
