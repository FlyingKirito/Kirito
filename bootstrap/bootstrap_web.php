<?php

use Phalcon\Mvc\Micro;

include dirname(__DIR__).'/vendor/autoload.php';

$app = new Micro();

$router = include dirname(__DIR__).'/config/route.php';
$dependency = new \Kirito\Server\Dependency();
$dependency->initView();

$app->setService('router', $router, true);
$app->setDi($dependency->getDi());
$app->handle();
