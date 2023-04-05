<?php

namespace Modules\Helpdesk\Widgets;

use App\Abstracts\Widget;
use Modules\Helpdesk\Models\Ticket;

class LatestTickets extends Widget
{
    public $default_name = 'helpdesk::widgets.latest_tickets';

    public $default_settings = [
        'width' => 'w-full lg:w-1/3 px-6',
    ];
    
    public $description = 'helpdesk::widgets.description.latest_tickets';

    public function show()
    {
        $query = Ticket::orderBy('created_at', 'desc')->take(5);


        $latest_tickets = $this->applyFilters($query, ['date_field' => 'created_at'])->get();

        return $this->view('helpdesk::widgets.latest_tickets', [
            'latest_tickets' => $latest_tickets,
        ]);
    }
}
