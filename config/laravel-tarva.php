<?php

return [
    'middlewares' => [
        /** web is mandatory */
        'web',
        /** strongly recommended */
        'auth'
    ],

    /** optional */
    'resources' => [
        'directory' => app_path() . '/Tarva/Resources',
        'regex' => null,
        /** should match PSR4 */
        'namespace' => '\App\Tarva\Resources\\'
    ],

    /** optional */
    'pages' => [
        'directory' => app_path() . '/Tarva/Pages',
        'regex' => null,
        /** should match PSR4 */
        'namespace' => '\App\Tarva\Pages\\'
    ],
    'auth' => [
        'controller' => \App\Http\Controllers\Auth\LoginController::class,
        'route' => 'laravel-tarva::login',
        'middleware' => \App\Http\Middleware\Authenticate::class,
    ]
];
