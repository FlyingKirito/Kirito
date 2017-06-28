<?php

use Phalcon\Mvc\Micro;

include dirname(__DIR__).'/vendor/autoload.php';

$app = new Micro();

//$routes = include dirname(__DIR__).'/config/route.php';
$router = new Phalcon\Mvc\Router;
$router->addGet(
    '/say/hello/{name}',
    array(
        'namespace' => 'Kirito\Controller',
        'controller' => 'Test',
        'action' => 'index'
    )
);
$app->setService('router', $router, true);

$app->handle();
