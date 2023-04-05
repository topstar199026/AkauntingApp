<?php

namespace Modules\Helpdesk\Widgets;

use App\Abstracts\Widget;
use App\Models\Auth\User;

class TopAssignees extends Widget
{
    public $default_name = 'helpdesk::widgets.top_assignees';

    public $default_settings = [
        'width' => 'w-full lg:w-1/3 px-6',
    ];

    public $description = 'helpdesk::widgets.description.top_assignees';

    public function show()
    {
        $query = User::withCount('helpdesk_tickets_assignee')->orderBy('helpdesk_tickets_assignee_count', 'desc');

        $assignees = $query->whereHas('helpdesk_tickets_assignee', function ($query) {
            $this->applyFilters($query, ['date_field' => 'created_at']);
        })->get();

        return $this->view('helpdesk::widgets.top_assignees', [
            'assignees' => $assignees,
        ]);
    }
}
