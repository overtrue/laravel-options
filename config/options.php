<?php

return [
    'defaults' => [
        'provider' => 'eloquent',
    ],

    'providers' => [
        'eloquent' => [
            'driver' => 'eloquent',
            'model' => \Overtrue\LaravelOptions\Option::class,
        ],
    ],
];
