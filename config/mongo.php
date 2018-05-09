<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MongoDb Host
    |--------------------------------------------------------------------------
    |
    | This defines the network host to try to connect to using the mongodb
    | client.
    |
    */
    'host' => env('MONGO_HOST', 'mongodb'),
    'database' => env('MONGO_DB', 'rss'),
];
