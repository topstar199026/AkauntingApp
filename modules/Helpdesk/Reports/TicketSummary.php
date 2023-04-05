<?php

namespace Modules\Helpdesk\Reports;

use App\Abstracts\Report;
use Modules\Helpdesk\Models\Ticket;

class TicketSummary extends Report
{
    public $default_name = 'helpdesk::reports.ticket_name';

    public $category = 'helpdesk::general.name';

    public $type = 'summary';

    public $icon = 'confirmation_number';

    public $has_money = false;

    public function setData()
    {
        $query = Ticket::with('category', 'owner');

        $tickets = $this->applyFilters($query, ['date_field' => 'created_at'])->get();

        $this->setArithmeticTotals($tickets, 'created_at');
    }

    public function getFields()
    {
        return [
            $this->getGroupField(),
            $this->getPeriodField(),
        ];
    }
}
