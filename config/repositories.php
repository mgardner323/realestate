<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Repository Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default repository driver that will be used
    | by the application. Alternative drivers may be setup below and switched
    | out as needed.
    |
    | Supported: "eloquent", "firestore"
    |
    */

    'driver' => env('DB_DRIVER_DEFAULT', 'eloquent'),
];