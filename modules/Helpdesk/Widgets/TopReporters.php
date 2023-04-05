<?php

namespace Modules\Helpdesk\Widgets;

use App\Abstracts\Widget;
use App\Models\Auth\User;

class TopReporters extends Widget
{
    public $default_name = 'helpdesk::widgets.top_reporters';

    public $default_settings = [
        'width' => 'w-full lg:w-1/3 px-6',
    ];

    public $description = 'helpdesk::widgets.description.top_reporters';

    public function show()
    {
        $query = User::withCount('helpdesk_tickets_reporter')->orderBy('helpdesk_tickets_reporter_count', 'desc');

        $reporters = $query->whereHas('helpdesk_tickets_reporter', function ($query) {
            $this->applyFilters($query, ['date_field' => 'created_at']);
        })->get();

        return $this->view('helpdesk::widgets.top_reporters', [
            'reporters' => $reporters,
        ]);
    }
}
