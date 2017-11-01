<?php

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$config = include __DIR__.'/config/parameters.php';

return [
    'paths' => [
        'migrations' => 'migrations'
    ],
    'environments' => [
        'default_migration_table' => 'migrate_log',
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $config['database']['default']['host'],
            'port' => $config['database']['default']['port'],
            'user' => $config['database']['default']['user'],
            'pass' => $config['database']['default']['pass'],
            'name' => $config['database']['default']['database'],
            'charset' => $config['database']['default']['charset']
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => $config['database']['testing']['host'],
            'port' => $config['database']['testing']['port'],
            'user' => $config['database']['testing']['user'],
            'pass' => $config['database']['testing']['pass'],
            'name' => $config['database']['testing']['database'],
            'charset' => $config['database']['testing']['charset']
        ],
    ],
];