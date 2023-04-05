<?php

use Modules\Projects\Models\Project;

return [

    Project::class => [
        [
            'location' => [
                'code' => 'projects-projects',
                'name' => 'projects::general.projects',
            ],
            'sort_orders' => [
                'name'          => 'general.name',
                'customer_id'   => ['general.contacts', 1],
                'description'   => 'general.description',
                'started_at'    => 'general.start_date',
                'ended_at'      => 'general.end_date',
                'members'       => ['projects::general.members', 2],
                'billing_type'  => 'projects::general.billing_type',
            ],
            'views' => [
                'crud' => [
                    'projects::projects.create',
                    'projects::projects.edit',
                ],
                'show' => [

                ],
            ],
        ],
    ],

];
