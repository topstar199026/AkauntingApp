<?php

return [

    'name'        => 'Credit/Packing Lists',
    'description' => 'Create credit or Packing Lists',

    'credit_notes' => 'Credit Note|Credit Notes',
    'debit_notes'  => 'Packing List|Packing Lists',

    'vendors' => 'Vendor|Vendors',

    'category' => 'Category',

    'empty' => [
        'credit_notes' => 'Credit notes are typically used when there has been an error in an already-issued invoice, such as an incorrect amount, or damaged goods, or when a customer wishes to change their original order.',
        'debit_notes'  => 'A packing list itemizes the contents of each package (box, pallets, etc). It includes weights, measurements and detailed lists of the goods in each package. The packing list should be included in carton or package, and can be attached to the outside of a package with a copy inside.',
    ],

];
