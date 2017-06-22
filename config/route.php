<?php

use phalcon\Mvc\Router;

$router = new Router();
$router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

$router->addGet('/', '\\Kirito\\Controller\\TestController::index');

return $router;
