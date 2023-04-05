<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Fallback
    |--------------------------------------------------------------------------
    |
    | Define fallback settings to be used in case the default is null
    |
    | Sample:
    |   "currency" => "USD",
    |
    */
    'fallback' => [
        'sales-purchase-orders' => [
            'sales_order' => [
                'number_prefix'             => env('SETTING_FALLBACK_SALES_ORDER_NUMBER_PREFIX', 'SO-'),
                'number_digit'              => env('SETTING_FALLBACK_SALES_ORDER_NUMBER_DIGIT', 5),
                'number_next'               => env('SETTING_FALLBACK_SALES_ORDER_NUMBER_NEXT', '1'),
                'item_name'                 => env('SETTING_FALLBACK_SALES_ORDER_ITEM_NAME', 'settings.invoice.item'),
                'price_name'                => env('SETTING_FALLBACK_SALES_ORDER_PRICE_NAME', 'settings.invoice.price'),
                'quantity_name'             => env('SETTING_FALLBACK_SALES_ORDER_QUANTITY_NAME', 'settings.invoice.quantity'),
                'hide_item_name'            => env('SETTING_FALLBACK_SALES_ORDER_HIDE_ITEM_NAME', false),
                'hide_item_description'     => env('SETTING_FALLBACK_SALES_ORDER_HIDE_ITEM_DESCRIPTION', false),
                'hide_quantity'             => env('SETTING_FALLBACK_SALES_ORDER_HIDE_QUANTITY', false),
                'hide_price'                => env('SETTING_FALLBACK_SALES_ORDER_HIDE_PRICE', false),
                'hide_amount'               => env('SETTING_FALLBACK_SALES_ORDER_HIDE_AMOUNT', false),
                'shipment_terms'            => env('SETTING_FALLBACK_SALES_ORDER_SHIPMENT_TERMS', 0),
                'template'                  => env('SETTING_FALLBACK_SALES_ORDER_TEMPLATE', 'default'),
                'color'                     => env('SETTING_FALLBACK_SALES_ORDER_COLOR', '#55588b'),
            ],
            'purchase_order' => [
                'number_prefix'             => env('SETTING_FALLBACK_SALES_ORDER_NUMBER_PREFIX', 'PO-'),
                'number_digit'              => env('SETTING_FALLBACK_SALES_ORDER_NUMBER_DIGIT', 5),
                'number_next'               => env('SETTING_FALLBACK_SALES_ORDER_NUMBER_NEXT', '1'),
                'item_name'                 => env('SETTING_FALLBACK_SALES_ORDER_ITEM_NAME', 'settings.invoice.item'),
                'price_name'                => env('SETTING_FALLBACK_SALES_ORDER_PRICE_NAME', 'settings.invoice.price'),
                'quantity_name'             => env('SETTING_FALLBACK_SALES_ORDER_QUANTITY_NAME', 'settings.invoice.quantity'),
                'hide_item_name'            => env('SETTING_FALLBACK_SALES_ORDER_HIDE_ITEM_NAME', false),
                'hide_item_description'     => env('SETTING_FALLBACK_SALES_ORDER_HIDE_ITEM_DESCRIPTION', false),
                'hide_quantity'             => env('SETTING_FALLBACK_SALES_ORDER_HIDE_QUANTITY', false),
                'hide_price'                => env('SETTING_FALLBACK_SALES_ORDER_HIDE_PRICE', false),
                'hide_amount'               => env('SETTING_FALLBACK_SALES_ORDER_HIDE_AMOUNT', false),
                'delivery_terms'            => env('SETTING_FALLBACK_SALES_ORDER_DELIVERY_TERMS', 0),
                'template'                  => env('SETTING_FALLBACK_SALES_ORDER_TEMPLATE', 'default'),
                'color'                     => env('SETTING_FALLBACK_SALES_ORDER_COLOR', '#55588b'),
            ],
        ]
    ],

];
