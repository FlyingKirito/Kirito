<?php

include dirname(__DIR__).'/vendor/autoload.php';

$config = include dirname(__DIR__).'/config/parameters.php';
$kernel = new Kirito\Kernel($config);

$app = $kernel->boot();
$app->handle();