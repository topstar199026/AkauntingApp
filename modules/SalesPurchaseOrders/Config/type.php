<?php

use Modules\SalesPurchaseOrders\Models\PurchaseOrder\Model as PurchaseOrder;
use Modules\SalesPurchaseOrders\Models\SalesOrder\Model as SalesOrder;
use Modules\SalesPurchaseOrders\Notifications\PurchaseOrder as PurchaseOrderNotification;
use Modules\SalesPurchaseOrders\Notifications\SalesOrder as SalesOrderNotification;

return [
    'document' => [
        SalesOrder::TYPE => [
            'alias'               => 'sales-purchase-orders',
            'group'               => '',
            'route'               => [
                'prefix'    => 'sales-orders', // core use with group + prefix, module ex. estimates
                'parameter' => 'sales_order', // sales/invoices/{parameter}/edit
                //'create' => 'invoices.create', // if you change route, you can write full path
            ],
            'permission'          => [
                'prefix' => 'sales-orders', // this controller file name.
                //'create' => 'create-sales-invoices', // if you change action permission key, you can write full permission
            ],
            'translation'         => [
                'prefix' => 'sales_orders', // this translation file name.
            ],
            'setting'             => [
                'prefix' => 'sales_order',
            ],
            'category_type'       => 'income',
            'transaction_type'    => 'income',
            'contact_type'        => 'customer', // use contact type
            'image_empty_page'    => 'public/img/empty_pages/default.png',
            'docs_path'           => 'https://akaunting.com/apps/sales-purchase-orders',
            'search_string_model' => SalesOrder::class,
            'hide'                => [], // for document items
            'class'               => [],
            'notification' => [
                'class'             => SalesOrderNotification::class,
                'notify_contact'    => true,
                'notify_user'       => true,
            ],
            'script' => [
                'folder'            => 'common',
                'file'              => 'documents',
            ],
        ],

        PurchaseOrder::TYPE => [
            'alias'               => 'sales-purchase-orders',
            'group'               => '',
            'route'               => [
                'prefix'    => 'purchase-orders', // core use with group + prefix, module ex. estimates
                'parameter' => 'purchase_order', // sales/invoices/{parameter}/edit
                //'create' => 'invoices.create', // if you change route, you can write full path
            ],
            'permission'          => [
                'prefix' => 'purchase-orders', // this controller file name.
                //'create' => 'create-sales-invoices', // if you change action permission key, you can write full permission
            ],
            'translation'         => [
                'prefix'       => 'purchase_orders', // this translation file name.
                'contact_info' => 'bills.bill_from',
            ],
            'setting'             => [
                'prefix' => 'purchase_order',
            ],
            'category_type'       => 'expense',
            'transaction_type'    => 'expense',
            'contact_type'        => 'vendor', // use contact type
            'image_empty_page'    => 'public/img/empty_pages/default.png',
            'docs_path'           => 'https://akaunting.com/apps/sales-purchase-orders',
            'search_string_model' => PurchaseOrder::class,
            'hide'                => [], // for document items
            'class'               => [],
            'notification' => [
                'class'             => PurchaseOrderNotification::class,
                'notify_contact'    => false,
                'notify_user'       => true,
            ],
            'script' => [
                'folder'            => 'common',
                'file'              => 'documents',
            ],
        ],
    ],
];
