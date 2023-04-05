<?php

return [

    Modules\Appointments\Models\Appointment::class => [
        'columns' => [
            'appointment_name' => ['searchable' => true],
            'enabled' => ['boolean' => true],
        ],
    ],

    Modules\Appointments\Models\Question::class => [
        'columns' => [
            'question' => ['searchable' => true],
            'enabled' => ['boolean' => true],
        ],
    ],

    Modules\Appointments\Models\Scheduled::class => [
        'columns' => [
            'name' => ['searchable' => true],
        ],
    ],
];
