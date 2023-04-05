<?php

use Modules\Estimates\Models\Estimate;

return [
    Estimate::class => [
        [
            'location' => [
                'code' => 'sales-estimates',
                'name' => 'estimates::general.estimates',
            ],
            'sort_orders' => [
                'issued_at'             => 'estimates::estimates.invoice_date',
                'document_number'       => 'estimates::estimates.invoice_number',
                'item_custom_fields'    => ['general.items', 2],
                'notes'                 => ['general.notes', 2],
                'category_id'           => ['general.categories', 1],
                'recurring'             => ['general.pictures', 1],
                'attachment'            => 'general.attachment',
            ],
            'views' => [
                'crud' => [
                    'estimates::estimates.create',
                    'estimates::estimates.edit',
                    'estimates::portal.estimates.edit'
                ],
                'show' => [
                    'estimates::estimates.show',
                    'estimates::estimates.print*',
                    'estimates::portal.estimates.show'
                ],
            ],
        ],
    ],
];
