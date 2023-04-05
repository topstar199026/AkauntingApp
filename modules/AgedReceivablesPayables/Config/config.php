<?php

return [
    'periods' => [
        [
            'name' => trans('aged-receivables-payables::general.0-30-days'),
            'slug' => '0-30-days',
            'color' => '#482F3A',
            'min' => 1,
            'max' => 30,
        ],
        [
            'name' => trans('aged-receivables-payables::general.31-60-days'),
            'slug' => '31-60-days',
            'color' => '#482F3A',
            'min' => 31,
            'max' => 60,
        ],
        [
            'name' => trans('aged-receivables-payables::general.61-90-days'),
            'slug' => '61-90-days',
            'color' => '#482F3A',
            'min' => 61,
            'max' => 90,
        ],
        [
            'name' => trans('aged-receivables-payables::general.over-90-days'),
            'slug' => 'over-90-days',
            'color' => '#482F3A',
            'min' => 91,
            'max' => null,
        ],
    ]
];
