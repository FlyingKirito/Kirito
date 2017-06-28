<?php

namespace Kirito\Server;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;

class Kernel
{
    private $config;
    private $app;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function boot()
    {
        $this->init();
    }

    private function init()
    {
        $this->app = new Micro();
        $this->initController();
        $this->app->handle();
    }

    private function initController()
    {
        $collection = new Collection();

        $controllersRoutes = $this->config['route'];echo '<pre>';
        foreach ($controllersRoutes as $controllerName => $routes) {
            $className = 'Kirito\\Controller\\'.ucfirst($controllerName);
            $controller = new $className();
            $collection->setHandler($controller);
            $collection->setPrefix($routes['prefix']);
            foreach ($routes['routes'] as $route) {
                $collection->$route['method']($route['route'], $route['action']);
            }
            $this->app->mount($collection);
        }

        $this->app->notFound(function () {
            echo '404 File not found';
        });
        return $collection;
    }
}