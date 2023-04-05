<?php

return [

    'name'        => 'Leaves',
    'description' => 'Manage the time-off for employees.',

    'leaves' => 'Leave|Leaves',

    'entitlements' => 'Entitlement|Entitlements',
    'calendar'     => 'Calendar',

    'policies'    => 'Policy|Policies',
    'leave_types' => 'Leave Type|Leave Types',
    'years'       => 'Year|Years',

    'leave_policy' => 'Leave Policy',
    'leave_year'   => 'Leave Year',

    'empty' => [
        'entitlements' => 'Companies may have different leave policies for different employees, so setting leave policies and assigning these policies to employees is important for managing the process. These assignments are called the leave entitlements.',
    ],

    'default' => [
        'leave_types' => [
            'casual_leave' => [
                'name'        => 'Casual Leave',
                'description' => 'This leave is granted for certain unforeseen situation or where an employee requires to go for one or two days leave'
            ],
            'sick_leave'   => [
                'name'        => 'Sick Leave',
                'description' => 'Employees can take this leave when they can\'t work because of a personal illness or injury',
            ],
        ],
        'policies'    => [
            'annual_leave' => [
                'name' => 'Annual Leave',
            ],
        ],
    ],

];
