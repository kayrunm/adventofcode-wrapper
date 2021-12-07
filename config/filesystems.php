<?php

return [

    'default' => 'input',

    'disks' => [
        'solutions' => [
            'driver' => 'local',
            'root' => app_path('Solutions/'),
        ],

        'input' => [
            'driver' => 'local',
            'root' => base_path('input/'),
        ],

        'stubs' => [
            'driver' => 'local',
            'root' => base_path('stubs/'),
        ],
    ],
];
