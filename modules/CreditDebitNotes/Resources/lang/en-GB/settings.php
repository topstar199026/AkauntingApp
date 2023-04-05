<?php

return [

    'credit_note' => [
        'description'     => 'Customize credit note prefix, number, terms, footer etc',
        'prefix'          => 'Number Prefix',
        'digit'           => 'Number Digit',
        'next'            => 'Next Number',
        'logo'            => 'Logo',
        'item_name'       => 'Item Name',
        'item'            => 'Items',
        'price_name'      => 'Price Name',
        'price'           => 'Price',
        'quantity_name'   => 'Quantity Name',
        'quantity'        => 'Quantity',
        'title'           => 'Title',
        'subheading'      => 'Subheading',
        'choose_template' => 'Choose credit note template',
        'default'         => 'Default',
        'classic'         => 'Classic',
        'modern'          => 'Modern',

        'form_description' => [
            'general'  => 'Set the defaults for formatting your credit note numbers.',
            'template' => 'Select one of the templates below for your credit notes.',
            'default'  => 'Selecting defaults for credit notes will pre-populate titles, subheadings, notes, and footers. So you don\'t need to edit credit notes each time to look more professional.',
        ],
    ],

    'debit_note' => [
        'description'     => 'Customize Packing List prefix, number, terms etc',
        'prefix'          => 'Number Prefix',
        'digit'           => 'Number Digit',
        'next'            => 'Next Number',
        'logo'            => 'Logo',
        'item_name'       => 'Item Name',
        'item'            => 'Items',
        'price_name'      => 'Price Name',
        'price'           => 'Price',
        'quantity_name'   => 'Quantity Name',
        'quantity'        => 'Quantity',
        'title'           => 'Title',
        'subheading'      => 'Subheading',
        'default'         => 'Default',
        'classic'         => 'Classic',
        'modern'          => 'Modern',

        'form_description' => [
            'general'  => 'Set the defaults for formatting your debit note numbers.',
        ],
    ],

    'email' => [
        'templates' => [
            'credit_note_new_customer' => 'New Credit Note Template (sent to customer)',
        ],
    ],

];
