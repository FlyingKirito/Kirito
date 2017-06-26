<?php

use Phalcon\Mvc\Micro;

include dirname(__DIR__).'/vendor/autoload.php';

$app = new Micro();

//$testController = new \Kirito\Controller\TestController();
//$app->get('/say/hello/{name}', array($testController, 'sayAction'));
$router = include dirname(__DIR__).'/config/route.php';
$dependency = new \Kirito\Server\Dependency();
$dependency->init();

$router->setDi($dependency->getDI());
$router->handle();
$app->setService('router', $router, true);
$app->setDi($dependency->getDI());

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo 'This is crazy, but this page was not found!';
});
var_dump($router->getMatchedRoute()->getRouteId());
$app->handle();
