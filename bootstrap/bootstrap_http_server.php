<?php

use Kirito\Server\HttpServer;

include dirname(__DIR__).'/vendor/autoload.php';

$config = include dirname(__DIR__).'/config/parameters.php';
$kernel = new Kirito\Kernel($config);

$class = new HttpServer;
$class->setKernel($kernel);
return $class;