<?php

return [

    'name'        => 'Vacances',
    'description' => 'Gestiona les absències dels treballadors.',

    'leaves' => 'Vacances|Vacances',

    'entitlements' => 'Permís|Permisos',
    'calendar'     => 'Calendari',

    'policies'    => 'Política|Polítiques',
    'leave_types' => 'Tipus de vacances|Tipus de vacances',
    'years'       => 'Any|Anys',

    'leave_policy' => 'Política de vacances',
    'leave_year'   => 'Any de vacances',

    'empty' => [
        'entitlements' => 'Les empreses poden tenir diverses polítiques de vacances en funció del treballador, de manera que configurar aquestes polítiques és important per la gestió de les vacances de l\'empresa. Aquestes assignacions s\'anomenen drets adquirits.',
    ],

    'default' => [
        'leave_types' => [
            'casual_leave' => [
                'name'        => 'Baixa temporal',
                'description' => 'Aquesta baixa o permís permet als treballadors fer ús d\'alguns dies de vacances en cas d\'imprevistos'
            ],
            'sick_leave'   => [
                'name'        => 'Permís per malatia',
                'description' => 'Els treballadors poden disposar d\'aquest permís quan no poden treballar per causes de malatía o lesió',
            ],
        ],
        'policies'    => [
            'annual_leave' => [
                'name' => 'Permís anual',
            ],
        ],
    ],

];
