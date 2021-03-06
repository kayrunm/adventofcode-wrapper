<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Advent of Code session ID
    |--------------------------------------------------------------------------
    |
    | This session ID is used to get your unique challenge input. To find
    | your own session ID, you'll need to log in to the Advent of Code
    | website and then copy what is stored in the `session` cookie.
    |
    */

    'session' => env('AOC_SESSION'),

    /*
    |--------------------------------------------------------------------------
    | Years
    |--------------------------------------------------------------------------
    |
    | In here you can specify which years challenges should be available.
    |
    */

    'years' => [

        'lowest' => env('LOWEST_YEAR'),

        'current' => env('CURRENT_YEAR'),

    ],
];
