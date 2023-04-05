<?php

return [

    Modules\Leaves\Models\Settings\Policy::class => [
        'columns' => [
            'id',
            'leave_type_id' => ['searchable' => true],
            'year_id'       => ['searchable' => true],
            'department_id'   => ['searchable' => true],
            'gender'        => ['searchable' => true],
        ],
    ],

    Modules\Leaves\Models\Employee::class => [
        'columns' => [
            'department_id' => ['searchable' => true],
            'gender'      => ['searchable' => true],
        ],
    ],

    Modules\Leaves\Models\Entitlement::class => [
        'columns' => [
            'employee' => [
                'relationship' => true,
                'route'        => 'leaves.employees.index'
            ],
            'policy'   => [
                'relationship' => true,
                'route'        => 'leaves.settings.policies.index'
            ],
        ],
    ],

];
