<?php

namespace Kirito\Server;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;
use Pimple\Container;

class Kernel extends Container
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

    public function service($name)
    {
    }

    public function dao($name)
    {

    }

    private function init()
    {
        $this->app = new Micro();
        $this->registerController();
        $this->registerService();
        $this->app->handle();
    }

    private function registerController()
    {
        $collection = new Collection();

        $controllersRoutes = $this->config['route'];
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
        $this->app->get('/', function () {
            echo 'Welcome to Flying Kirito !';
        });
        $this->app->notFound(function () {
            echo '404 File not found';
        });

        return $collection;
    }

    private function registerService()
    {
        if (file_exists(dirname(__DIR__)."/Service/Implement/{}.php")) {

        }
    }
}