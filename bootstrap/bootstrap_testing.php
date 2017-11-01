<?php

include_once dirname(__DIR__).'/vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(dirname(__DIR__), '.env-testing');
$dotenv->load();

$config = include dirname(__DIR__).'/config/parameters-testing.php';
$kernel = new Kirito\Kernel($config);
$kernel->boot();
return $kernel;
