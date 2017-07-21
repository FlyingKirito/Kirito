<?php

return [
    'host' => '0.0.0.0',
    'port' => '9371',
    'setting' => [
        'worker_num' => 3,
        'backblog' => 128,
        'max_request' => 100,
        'daemonize' => false,
        'log_file' => dirname(__DIR__).'/var/log/swoole.log',
        'pid_file' => dirname(__DIR__).'/var/pid/socket_server.pid',
    ]
];