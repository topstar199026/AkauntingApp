<?php

use Modules\Projects\Models\Milestone;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\ProjectTaskTimesheet;
use Modules\Projects\Models\Task;

return [
    Project::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'description' => ['searchable' => true],
            'status' => [
                'values' => [
                    'inprogress' => 'projects::general.inprogress',
                    'completed' => 'projects::general.completed',
                    'canceled' => 'projects::general.canceled',
                ],
            ],
            'customer_id' => [
                'route' => ['customers.index', 'search=enabled:1'],
            ],
            'started_at' => [
                'key' => 'started_at',
                'translation' => trans('general.start_date'),
                'date' => true,
            ],
            'ended_at' => [
                'key' => 'ended_at',
                'translation' => trans('general.end_date'),
                'date' => true,
            ],
        ],
    ],
    Task::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'description' => ['searchable' => true],
            'status' => [
                'values' => [
                    'not-started' => 'projects::general.not-started',
                    'active' => 'projects::general.active',
                    'completed' => 'projects::general.completed',
                ],
            ],
            'priority' => [
                'values' => [
                    'low' => 'projects::general.low',
                    'medium' => 'projects::general.medium',
                    'high' => 'projects::general.high',
                    'urgent' => 'projects::general.urgent',
                ],
            ],
            'started_at' => [
                'key' => 'started_at',
                'translation' => trans('general.start_date'),
                'date' => true,
            ],
            'deadline_at' => [
                'key' => 'deadline_at',
                'translation' => trans('general.end_date'),
                'date' => true,
            ],
        ],
    ],
    ProjectTaskTimesheet::class => [
        'columns' => [
            'user_id' => [
                'route' => ['users.index', 'search=enabled:1'],
            ],
            'started_at' => [
                'key' => 'started_at',
                'translation' => trans('general.start_date'),
                'date' => true,
            ],
            'ended_at' => [
                'key' => 'ended_at',
                'translation' => trans('general.end_date'),
                'date' => true,
            ],
        ]
    ],
    Milestone::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'description' => ['searchable' => true],
            'deadline_at' => [
                'key' => 'deadline_at',
                'translation' => trans('general.end_date'),
                'date' => true,
            ],
        ],
    ],
];
