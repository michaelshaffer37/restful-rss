<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When the application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within the
    | application. If disabled, a simple generic error page is shown.
    |
    */
    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application Hostname
    |--------------------------------------------------------------------------
    |
    | When application resources are created a v5 UUID is generated as the
    | namespace for all generated resources.  This namespace is then used to
    | generate resource id's for global uniqueness.
    |
    */
    'hostname' => env('APP_HOSTNAME', 'localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */
    'url' => env('APP_URL', 'http://localhost:8181'),
];
