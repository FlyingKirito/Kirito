<?php

return [
    'route' => include dirname(__DIR__).'/config/route.php',
    'database' => [
        'default' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'root',
            'pass' => '',
            'database' => 'kirito',
            'charset' => 'utf8',
            'driver' => 'pdo_mysql'
        ],
        'testing' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'root',
            'pass' => '',
            'database' => 'kirito-dev',
            'charset' => 'utf8',
            'driver' => 'pdo_mysql'
        ],
    ],
    'redis' => [
        'default' => [
            'host' => '127.0.0.1',
            'port' => '6379',
        ],
        'testing' => [
            'host' => '127.0.0.1',
            'port' => '6380',
        ],
    ],
    'httpServer' => include dirname(__DIR__).'/config/httpServer.php',
    'socketServer' => include dirname(__DIR__).'/config/socketServer.php',
];