<?php

return [
    'host' => '127.0.0.1',
    'port' => '9271',
    'setting' => [
        'worker_num' => 1,
        'backblog' => 128,
        'max_request' => 100,
        'daemonize' => true,
        'log_file' => dirname(__DIR__).'/var/log/swoole.log',
        'pid_file' => dirname(__DIR__).'/var/pid/http_server.pid',
    ]
];