<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    */
    'php_version' => '7.2.5',

    'extensions' => [
        'php' => [
            'BCMath',
            'Ctype',
            'Fileinfo',
            'JSON',
            'Mbstring',
            'OpenSSL',
            'PDO',
            'Tokenizer',
            'XML',
            'GD',
            'cURL'
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File permissions
    |--------------------------------------------------------------------------
    */
    'permissions' => [
        'Files' => [
            '.env',
        ],
        'Folders' =>
        [
            'bootstrap/cache',
            'lang',
            'public/uploads/brand',
            'storage',
            'storage/framework/',
            'storage/framework/cache',
            'storage/framework/cache/data',
            'storage/framework/sessions',
            'storage/framework/views',
            'storage/logs',
        ],
    ]
];
