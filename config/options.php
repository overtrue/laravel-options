<?php

use Overtrue\LaravelOptions\Option;

return [
    'defaults' => [
        'provider' => 'eloquent',
    ],

    'providers' => [
        'eloquent' => [
            'driver' => 'eloquent',
            'model' => Option::class,
        ],
    ],
];
