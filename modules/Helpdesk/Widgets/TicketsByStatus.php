<?php

namespace Modules\Helpdesk\Widgets;

use App\Abstracts\Widget;
use Modules\Helpdesk\Models\Status;

class TicketsByStatus extends Widget
{
    public $default_name = 'helpdesk::widgets.tickets_by_status';

    public $description = 'helpdesk::widgets.description.tickets_by_status';

    public $report_class = 'Modules\Helpdesk\Reports\TicketSummary';

    public function show()
    {
        $query = Status::withCount('helpdesk_tickets')->orderBy('helpdesk_tickets_count', 'desc');

        $query->whereHas('helpdesk_tickets', function ($query) {
            $this->applyFilters($query, ['date_field' => 'created_at']);
        })->each(function ($status) {
            $this->addToDonut($status->color, $status->name, $status->helpdesk_tickets_count);
        });

        $chart = $this->getDonutChart(trans('helpdesk::widgets.tickets_by_status'), '100%', 300, 6);

        return $this->view('widgets.donut_chart', [
            'chart' => $chart,
        ]);
    }
}
