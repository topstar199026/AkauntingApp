<?php

namespace Modules\Helpdesk\BulkActions;

use App\Abstracts\BulkAction;
use Modules\Helpdesk\Exports\Tickets as Export;
use Modules\Helpdesk\Jobs\DeleteTicket;
use Modules\Helpdesk\Models\Ticket;

class Tickets extends BulkAction
{
    public $model = Ticket::class;

    public $text = 'helpdesk::general.tickets';

    public $path = [
        'group' => 'helpdesk',
        'type' => 'tickets',
    ];

    public $actions = [
        'delete' => [
            'name' => 'general.delete',
            'message' => 'bulk_actions.message.delete',
            'permission' => 'delete-helpdesk-tickets',
        ],
        'export' => [
            'name' => 'general.export',
            'message' => 'bulk_actions.message.export',
            'type' => 'download',
        ],
    ];

    public function destroy($request)
    {
        $tickets = $this->getSelectedRecords($request, 'replies');

        foreach ($tickets as $ticket) {
            try {
                $this->dispatch(new DeleteTicket($ticket));
            } catch (\Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }

    public function export($request)
    {
        $selected = $this->getSelectedInput($request);

        return $this->exportExcel(new Export($selected), trans_choice('helpdesk::general.tickets', 2));
    }
}
