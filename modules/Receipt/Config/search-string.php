<?php

use Modules\Receipt\Models\Receipt;

return [
    Receipt::class => [
        'columns' => [
            'date' => [
                'key' => 'Date',
                'date' => true,
            ],
            'merchant' => ['searchable' => true],
            'category_id' => [
                'route' => 'categories.index'
            ],
            'contact_id' => [
                'route' => ['vendors.index', 'search=enabled:1'],
            ],
        ],
    ],
];
