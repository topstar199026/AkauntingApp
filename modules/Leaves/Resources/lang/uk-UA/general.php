<?php

return [

    'name'        => 'Листя',
    'description' => 'Керувати відгулами для працівників.',

    'leaves' => 'Залишати|Залишати',

    'entitlements' => 'Право|Права',
    'calendar'     => 'Календар',

    'policies'    => 'Політика|Політика',
    'leave_types' => 'Тип відпустки|Типи відпустки',
    'years'       => 'Рік|Роки',

    'leave_policy' => 'Політика відпустки',
    'leave_year'   => 'Рік відпустки',

    'empty' => [
        'entitlements' => 'Компанії можуть мати різну політику відпусток для різних працівників, тому встановлення політики відпусток та призначення цієї політики для працівників є важливим в процесі управління. Ці призначення називаються відпустками.',
    ],

    'default' => [
        'leave_types' => [
            'casual_leave' => [
                'name'        => 'Повсякденна відпустка',
                'description' => 'Ця відпустка надається у разі певної непередбачуваної ситуації або коли працівник необхідно піти у відпустку на один-два дні'
            ],
            'sick_leave'   => [
                'name'        => 'Лікарняний',
                'description' => 'Працівники можуть взяти цю відпустку, якщо вони не можуть працювати через особисту хворобу або травму',
            ],
        ],
        'policies'    => [
            'annual_leave' => [
                'name' => 'Щорічна відпустка',
            ],
        ],
    ],

];
