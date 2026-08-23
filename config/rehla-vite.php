<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Rehla Vite Configuration
    |--------------------------------------------------------------------------
    |
    | Please add your Vite registry here to seamlessly support the `rehla_assets` function.
    |
    */

    'viters' => [
        'admin' => [
            'hot_file' => 'admin-default-vite.hot',
            'build_directory' => 'themes/admin/default/build',
            'package_assets_directory' => 'src/Resources/assets',
        ],

    ],
];