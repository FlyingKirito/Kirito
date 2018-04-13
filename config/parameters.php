<?php

return [
    'route' => include dirname(__DIR__).'/config/route.php',
    'database' => [
        'default' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'root',
            'pass' => '',
            'dbname' => 'kirito',
            'charset' => 'utf8',
            'driver' => 'pdo_mysql'
        ],
        'testing' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'root',
            'pass' => '',
            'dbname' => 'kirito-dev',
            'charset' => 'utf8',
            'driver' => 'pdo_mysql'
        ],
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379
    ]
];