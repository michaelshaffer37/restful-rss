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
];
