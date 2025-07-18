<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ngrok Configuration
    |--------------------------------------------------------------------------
    |
    | This value is the domain that ngrok uses to generate the secure URL.
    | If you are using the free plan, the domain will be randomly generated.
    |
    */

    'free_plan' => env('NGROK_FREE_PLAN', 'false'),
];
