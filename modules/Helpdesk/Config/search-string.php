<?php

return [

    'Modules\Helpdesk\Models\Ticket' => [
        'columns' => [
            'name' => ['searchable' => true],
            'subject' => ['searchable' => true],
            'message' => ['searchable' => true],
            'category_id' => [
                'route' => ['categories.index', 'search=type:ticket'],
            ],
            'status_id' => [
                'route' => 'helpdesk.statuses.index'
            ],
            'created_at' => [
                'date' => true
            ],
            'updated_at' => [
                'date' => true
            ],
        ],
    ],

    Modules\Helpdesk\Models\Portal\Ticket::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'subject' => ['searchable' => true],
            'message' => ['searchable' => true],
            'category_id' => [
                'route' => 'portal.helpdesk.tickets.categories',
            ],
            'status_id' => [
                'route' => 'portal.helpdesk.statuses.index'
            ],
            'created_at' => [
                'date' => true
            ],
            'updated_at' => [
                'date' => true
            ],
        ],
    ],

];
