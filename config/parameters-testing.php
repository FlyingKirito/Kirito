<?php

return [
    'route' => include dirname(__DIR__).'/config/route.php',
    'database' => [
        'default' => [
            'host' => getenv('DATABASE_DEFAULT_HOST'),
            'port' => getenv('DATABASE_DEFAULT_PORT'),
            'user' => getenv('DATABASE_DEFAULT_USER'),
            'pass' => getenv('DATABASE_DEFAULT_PWD'),
            'database' => getenv('DATABASE_DEFAULT_NAME'),
            'charset' => 'utf8',
            'driver' => 'pdo_mysql'
        ],
        'testing' => [
            'host' => getenv('DATABASE_TEST_HOST'),
            'port' => getenv('DATABASE_TEST_PORT'),
            'user' => getenv('DATABASE_TEST_USER'),
            'pass' => getenv('DATABASE_TEST_PWD'),
            'database' => getenv('DATABASE_TEST_NAME'),
            'charset' => 'utf8',
            'driver' => 'pdo_mysql'
        ],
    ],
    'redis' => [
        'default' => [
            'host' => getenv('REDIS_DEFAULT_HOST'),
            'port' => getenv('REDIS_DEFAULT_PORT'),
        ],
        'testing' => [
            'host' => getenv('REDIS_TEST_HOST'),
            'port' => getenv('REDIS_TEST_PORT'),
        ],
    ],
    'httpServer' => include dirname(__DIR__).'/config/httpServer.php',
    'socketServer' => include dirname(__DIR__).'/config/socketServer.php',
    'rpc' => [
        'im_api' => getenv('RPC_IM')
    ],
];
