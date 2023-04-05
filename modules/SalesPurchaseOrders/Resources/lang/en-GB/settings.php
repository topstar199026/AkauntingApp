<?php

return [

    'sales_order' => [
        'search_keywords'        => 'customize, sales, order, number, prefix, digit, next, logo,' .
                                    ' name, price, quantity, template, title, subheading, footer,' .
                                    ' note, hide, due, colour, shipment, terms, column',
        'item'            => 'Items',
        'price'           => 'Price',
        'rate'            => 'Rate',
        'quantity'        => 'Quantity',
        'shipment_terms'  => 'Shipment Terms',
        'choose_template' => 'Choose sales order template',
        'new_customer'    => 'New Sales Order Template (sent to customer)',

        'form_description' => [
            'general'                   => 'Set the defaults for formatting your sales order numbers and payment terms.',
            'template'                  => 'Select one of the templates below for your sales orders.',
            'default'                   => 'Selecting defaults for sales orders will pre-populate titles, subheadings,' .
                                           ' notes, and footers. So you don\'t need to edit estimate each time to ' .
                                           'look more professional.',
            'column'                    => 'Customize how the sales order columns are named. ' .
                                           'If you like to hide item descriptions and amounts in lines,' .
                                           ' you can change it here.',
        ]
    ],

    'purchase_order' => [
        'search_keywords'        => 'customize, purchase, order, number, prefix, digit, next, logo,' .
                                    ' name, price, quantity, template, title, subheading, footer,' .
                                    ' note, hide, due, colour, delivery, terms, column',
        'item'            => 'Items',
        'price'           => 'Price',
        'rate'            => 'Rate',
        'quantity'        => 'Quantity',
        'delivery_terms'  => 'Delivery Terms',
        'choose_template' => 'Choose purchase order template',
        'new_vendor'      => 'New Purchase Order Template (sent to vendor)',

        'form_description' => [
            'general'                   => 'Set the defaults for formatting your purchase order numbers and payment terms.',
            'template'                  => 'Select one of the templates below for your purchase orders.',
            'default'                   => 'Selecting defaults for purchase orders will pre-populate titles, subheadings,' .
                                           ' notes, and footers. So you don\'t need to edit estimate each time to ' .
                                           'look more professional.',
            'column'                    => 'Customize how the purchase order columns are named. ' .
                                           'If you like to hide item descriptions and amounts in lines,' .
                                           ' you can change it here.',
        ]
    ],

];
