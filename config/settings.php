<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application System Admin / Super Admin
    |--------------------------------------------------------------------------        
    |
    */
    'system_admin' => [
        'name'      => env('SYSTEM_ADMIN_NAME', 'System Admin'),
        'email'    => env('SYSTEM_ADMIN_EMAIL', 'system@admin.com'),
        'password'  => env('SYSTEM_ADMIN_PASSWORD', 'admin@123'),
    ],


];
