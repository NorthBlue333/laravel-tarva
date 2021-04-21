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
        'folder' => app_path() . '/Admin/Resources/*.php',
        /** should match PSR4 */
        'namespace' => '\App\Admin\Resources\\'
    ]
];
