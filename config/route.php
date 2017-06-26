<?php

use phalcon\Mvc\Router;

$router = new Router(false);
$router->addGet("/say/hello/{name}", array(
    'namespace' => 'Kirito\Controllers',
    'controller' => 'test',
    'action' => 'index'
));

return $router;
