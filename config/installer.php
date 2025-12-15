<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Installed Lock File
    |--------------------------------------------------------------------------
    | When this file exists, the installer is considered completed.
    */
    'installed_file' => storage_path('installed'),

    /*
    |--------------------------------------------------------------------------
    | Redirect after installation
    |--------------------------------------------------------------------------
    | Where to send the user after finishing installation.
    | Example: '/login' or '/dashboard'
    */
    'redirect_after_install' => '/login',

    /*
    |--------------------------------------------------------------------------
    | Admin user model
    |--------------------------------------------------------------------------
    | Change if your app uses a custom user model.
    */
    'user_model' => \App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Admin fields mapping
    |--------------------------------------------------------------------------
    | Map form fields to your user table columns.
    | If you have custom columns like 'is_admin' or 'role', you can add them here
    | and also define 'admin_defaults' below.
    */
    'admin_fields' => [
        'name'     => 'name',
        'email'    => 'email',
        'password' => 'password',
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin default values (optional)
    |--------------------------------------------------------------------------
    | Add any extra columns you want to set when creating the admin.
    | Example:
    | 'admin_defaults' => ['is_admin' => 1, 'role' => 'admin'],
    */
    'admin_defaults' => [],

    /*
    |--------------------------------------------------------------------------
    | Safe environment values during installation
    |--------------------------------------------------------------------------
    | Avoid common install crashes (like database cache table missing).
    */
    'safe_env' => [
        'CACHE_DRIVER'      => 'file',
        'SESSION_DRIVER'    => 'file',
        'QUEUE_CONNECTION'  => 'sync',
    ],
];
