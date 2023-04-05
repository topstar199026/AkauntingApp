<?php

namespace Modules\Helpdesk\Exports;

use App\Abstracts\Export;
use Modules\Helpdesk\Models\Ticket as Model;

class Tickets extends Export
{
    public function collection()
    {
        return Model::with('category', 'status', 'priority', 'owner')->collectForExport($this->ids);
    }

    public function map($model): array
    {
        $model->author_name = $model->owner->name;
        $model->category_name = $model->category->name;
        $model->status_name = $model->status->name;
        $model->priority_name = $model->priority->name;
        $model->assignee_name = $model->assignee->name;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'name',
            'category_name',
            'subject',
            'message',
            'author_name',
            'status_name',
            'priority_name',
            'assignee_name',
        ];
    }
}
