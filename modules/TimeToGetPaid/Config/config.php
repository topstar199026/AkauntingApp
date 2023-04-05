<?php

return [

    'periods' => [
        [
            'name' => trans('time-to-get-paid::general.0-15-days'),
            'slug' => '0-15-days',
            'color' => '#482F3A',
            'min' => 0,
            'max' => 15,
        ],
        [
            'name' => trans('time-to-get-paid::general.16-30-days'),
            'slug' => '16-30-days',
            'color' => '#482F3A',
            'min' => 16,
            'max' => 30,
        ],
        [
            'name' => trans('time-to-get-paid::general.31-45-days'),
            'slug' => '31-45-days',
            'color' => '#482F3A',
            'min' => 31,
            'max' => 45,
        ],
        [
            'name' => trans('time-to-get-paid::general.above-45-days'),
            'slug' => 'above-45-days',
            'color' => '#482F3A',
            'min' => 45,
            'max' => null,
        ],
    ],

];
