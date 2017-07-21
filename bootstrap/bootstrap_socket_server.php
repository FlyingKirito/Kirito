<?php

use Kirito\Server\SocketServer;

include dirname(__DIR__).'/vendor/autoload.php';

$config = include dirname(__DIR__).'/config/parameters.php';
$kernel = new Kirito\Kernel($config);

$server = new SocketServer();
$server->setKernel($kernel);
return $server;