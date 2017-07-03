<?php

return [
    'route' => include dirname(__DIR__).'/config/route.php',
    'register' => include dirname(__DIR__).'/config/register.php',
    'database' => [
        'default' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'root',
            'pass' => '',
            'database' => 'kirito',
            'charset' => 'utf8'
        ],
        'testing' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'root',
            'pass' => '',
            'database' => 'kirito-dev',
            'charset' => 'utf8'
        ],
    ],
];