<?php

return [

    'fallback' => [
        'inventory' => [
            'default_warehouse'             => env('SETTING_FALLBACK_INVENTORY_DEFAULT_WAREHOUSE', '1'),
            'barcode_type'                  => env('SETTING_FALLBACK_INVENTORY_BARCODE_TYPE', '1'),
            'barcode_print_template'        => env('SETTING_FALLBACK_INVENTORY_BARCODE_PRINT_TEMPLATE', 'single'),
            'track_inventory'               => env('SETTING_FALLBACK_INVENTORY_TRACK_INVENTORY', false),
            'negative_stock'                => env('SETTING_FALLBACK_INVENTORY_NEGATIVE_STOCK', false),
            'reorder_level_notification'    => env('SETTING_FALLBACK_INVENTORY_REORDER_LEVEL_NOTIFICATION', false),
            'transfer_order_prefix'         => env('SETTING_FALLBACK_INVENTORY_TRANSFER_ORDER_PREFIX', 'TO-'),
            'transfer_order_digit'          => env('SETTING_FALLBACK_INVENTORY_TRANSFER_ORDER_DIGIT', '5'),
            'transfer_order_next'           => env('SETTING_FALLBACK_INVENTORY_TRANSFER_ORDER_NEXT', '1'),
            'adjustment_prefix'             => env('SETTING_FALLBACK_INVENTORY_ADJUSTMENT_PREFIX', 'ADJ-'),
            'adjustment_digit'              => env('SETTING_FALLBACK_INVENTORY_ADJUSTMENT_DIGIT', '5'),
            'adjustment_next'               => env('SETTING_FALLBACK_INVENTORY_ADJUSTMENT_NEXT', '1'),
        ],
    ],
];
