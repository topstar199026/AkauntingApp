<?php

namespace Modules\Helpdesk\Imports;

use App\Abstracts\Import;
use Modules\Helpdesk\Http\Requests\Ticket as Request;
use Modules\Helpdesk\Models\Ticket as Model;
use Modules\Helpdesk\Models\Status;
use Modules\Helpdesk\Models\Priority;

class Tickets extends Import
{
    public function model(array $row)
    {
        return new Model($row);
    }

    public function map($row): array
    {
        $row = parent::map($row);

        // 'name' field is required to create the ticket
        // in order the mutator is called to autogenerate the ticket name/number.
        $row['name'] = 0;

        $row['category_id'] = $this->getCategoryId($row, 'ticket');
        $row['status_id'] = $this->getStatusId($row);
        $row['priority_id'] = $this->getPriorityId($row);

        return $row;
    }

    public function rules(): array
    {
        return (new Request())->rules();
    }

    public function getStatusId($row)
    {
        if (isset($row['status_name']))
            $id = Status::where('name', $row['status_name'])->pluck('id')->first();
        else
            $id = null;

        return is_null($id) ? Status::getFirstStatusID() : (int) $id;
    }

    public function getPriorityId($row)
    {
        if (isset($row['priority_name']))
            $id = Priority::where('name', $row['priority_name'])->pluck('id')->first();
        else
            $id = null;

        return is_null($id) ? Priority::getDefaultPriorityID() : (int) $id;
    }
}
