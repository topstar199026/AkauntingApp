<?php

use App\Models\Document\Document;
use Modules\SalesPurchaseOrders\Models\SalesOrder\Model as SalesOrder;
use Modules\SalesPurchaseOrders\Models\PurchaseOrder\Model as PurchaseOrder;

return [
    Document::class => [
        [
            'type' => SalesOrder::TYPE,
            'location' => [
                'code' => 'sales-sales-orders',
                'name' => 'sales-purchase-orders::general.sales_orders',
            ],
            'sort_orders' => [
                'title' => 'settings.invoice.title',
                'subheading' => 'settings.invoice.subheading',
                'company_logo' => 'settings.company.logo',
                // ------------------------
                'issued_at' => 'sales-purchase-orders::sales_orders.invoice_date',
                'document_number' => 'sales-purchase-orders::sales_orders.invoice_number',
                'expected_shipment_date' => 'sales-purchase-orders::sales_orders.expected_shipment_date',
                'order_number' => 'sales-purchase-orders::sales_orders.order_number',
                'item_custom_fields' => ['general.items', 2],
                'notes' => ['general.notes', 2],
                // ------------------------
                'footer' => 'general.footer',
                'category_id' => ['general.categories', 1],
                // 'attachment'            => 'general.attachment',
            ],
            'views' => [
                'crud' => [
                    'sales-purchase-orders::sales_orders.create',
                    'sales-purchase-orders::sales_orders.edit',
                ],
                'show' => [
                    'sales-purchase-orders::sales_orders.print_classic',
                    'sales-purchase-orders::sales_orders.print_default',
                    'sales-purchase-orders::sales_orders.print_modern',
                ],
            ],
            'show_types' => [
                'print' => [
                    'sales-purchase-orders::sales_orders.print_classic',
                    'sales-purchase-orders::sales_orders.print_default',
                    'sales-purchase-orders::sales_orders.print_modern',
                ],
            ],
            /*'tests' => [
                'factory' => ['invoice', 'items'],
                'routes' => [
                    'get' => 'invoices.create',
                    'post' => 'invoices.store',
                    'patch' => 'invoices.update',
                    'delete' => 'invoices.destroy',
                ],
            ],*/
            /*'export' => [
                'App\Exports\Sales\Sheets\Invoices',
                'App\Exports\Sales\Sheets\InvoiceItems'
            ],*/
        ],
        [
            'type' => PurchaseOrder::TYPE,
            'location' => [
                'code' => 'sales-purchase-orders',
                'name' => 'sales-purchase-orders::general.purchase_orders',
            ],
            'sort_orders' => [
                'title' => 'settings.invoice.title',
                'subheading' => 'settings.invoice.subheading',
                'company_logo' => 'settings.company.logo',
                // ------------------------
                'issued_at' => 'sales-purchase-orders::purchase_orders.invoice_date',
                'document_number' => 'sales-purchase-orders::purchase_orders.invoice_number',
                'expected_delivery_date' => 'sales-purchase-orders::purchase_orders.expected_delivery_date',
                'order_number' => 'sales-purchase-orders::purchase_orders.order_number',
                'item_custom_fields' => ['general.items', 2],
                'notes' => ['general.notes', 2],
                // ------------------------
                'footer' => 'general.footer',
                'category_id' => ['general.categories', 1],
                // 'attachment'            => 'general.attachment',
            ],
            'views' => [
                'crud' => [
                    'sales-purchase-orders::purchase_orders.create',
                    'sales-purchase-orders::purchase_orders.edit',
                ],
                'show' => [
                    'sales-purchase-orders::purchase_orders.print_classic',
                    'sales-purchase-orders::purchase_orders.print_default',
                    'sales-purchase-orders::purchase_orders.print_modern',
                ],
            ],
            'show_types' => [
                'print' => [
                    'sales-purchase-orders::purchase_orders.print_classic',
                    'sales-purchase-orders::purchase_orders.print_default',
                    'sales-purchase-orders::purchase_orders.print_modern',
                ],
            ],
        ],
    ],
];



