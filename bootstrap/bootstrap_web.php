<?php

include dirname(__DIR__).'/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(dirname(__DIR__), '.env');
$dotenv->load();

$config = include dirname(__DIR__).'/config/parameters.php';
$kernel = new Kirito\Kernel($config);

$app = $kernel->boot();
$app->handle();