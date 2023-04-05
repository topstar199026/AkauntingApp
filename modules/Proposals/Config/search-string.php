<?php

return [

    \Modules\Proposals\Models\Proposal::class => [
        'columns' => [
            'id',
            'estimate.document_number'  => ['searchable' => true],
            'description'               => ['searchable' => true],
        ],
    ],

    \Modules\Proposals\Models\Template::class => [
        'columns' => [
            'name'                      => ['searchable' => true],
            'description'               => ['searchable' => true],
        ],
    ],

];
