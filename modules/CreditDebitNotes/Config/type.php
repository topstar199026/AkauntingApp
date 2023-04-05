<?php

return [
    'document' => [
        \Modules\CreditDebitNotes\Models\CreditNote::TYPE => [
            'alias'                     => 'credit-debit-notes',
            'group'                     => 'credit-debit-notes',
            'route'                     => [
                'prefix'    => 'credit-notes',
                'parameter' => 'credit_note',
            ],
            'permission'                => [
                'prefix' => 'credit-notes',
            ],
            'translation'               => [
                'prefix'             => 'credit_notes',
                'advanced_accordion' => 'credit-debit-notes::general.category',
            ],
            'setting'                   => [
                'prefix' => 'credit_note',
            ],
            'category_type'             => 'income',
            'transaction_type'          => 'income',
            'contact_type'              => 'customer',
            'inventory_stock_action'    => 'increase', // increases stock in stock tracking 
            'hide'                      => [],
            'class'                     => [],
            'script'                    => [
                'folder' => 'credit_notes',
                'file'   => 'documents',
            ],
            'search_string_model'       => 'Modules\CreditDebitNotes\Models\CreditNote',
            'status_workflow'           => [
                'draft'     => 'send',
                'sent'      => 'make-refund',
                'cancelled' => 'restore',
            ],
        ],

        \Modules\CreditDebitNotes\Models\DebitNote::TYPE => [
            'alias'                     => 'credit-debit-notes',
            'group'                     => 'credit-debit-notes',
            'route'                     => [
                'prefix'    => 'debit-notes',
                'parameter' => 'debit_note',
            ],
            'permission'                => [
                'prefix' => 'debit-notes',
            ],
            'translation'               => [
                'prefix'             => 'debit_notes',
                'advanced_accordion' => 'credit-debit-notes::general.category',
            ],
            'setting'                   => [
                'prefix' => 'debit_note',
            ],
            'category_type'             => 'expense',
            'transaction_type'          => 'expense',
            'contact_type'              => 'vendor',
            'inventory_stock_action'    => 'decrease', // decrease stock in stock tracking
            'hide'                      => [],
            'class'                     => [],
            'script'                    => [
                'folder' => 'debit_notes',
                'file'   => 'documents',
            ],
            'search_string_model'       => 'Modules\CreditDebitNotes\Models\DebitNote',
        ],
    ],
];
