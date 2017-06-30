<?php

namespace Kirito;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;
use Pimple\Container;

class Kernel extends Container
{
    private $config;
    private $app;

    const SERVICE_KEY = 'Service_%s';
    const DAO_KEY = 'Dao_%s';

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
        $key = sprintf(self::SERVICE_KEY, $name);
        if($this->offsetExists($key)) {
            return $this[$key];
        }
    }

    public function dao($name)
    {
        $key = sprintf(self::DAO_KEY, $name);
        if($this->offsetExists($key)) {
            return $this[$key];
        }
    }

    private function init()
    {
        $this->app = new Micro();
        $this->registers();
        $this->app->handle();
    }

    private function registerController()
    {
        $collection = new Collection();

        $controllersRoutes = $this->config['route'];
        foreach ($controllersRoutes as $controllerName => $routes) {
            $className = __NAMESPACE__.'\\Controller\\'.ucfirst($controllerName);
            $controller = new $className();
            $controller->setKernel($this);
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

    private function registers()
    {
        $this->registerController();
        $this->registerBusiness();
    }

    private function registerBusiness()
    {
        $register = $this->config['register'];

        if (!empty($register['services'])) {
            foreach ($register['services'] as $serviceName) {
                $class = __NAMESPACE__.'\\Service\\Implement\\'.ucfirst($serviceName).'Impl';
                if (class_exists($class)) {
                    $this["Service_{$serviceName}"] = new $class;
                }
            }
        }

        if (!empty($register['daos'])) {
            foreach ($register['daos'] as $daoName) {
                $class = __NAMESPACE__."\\Dao\\{$daoName}";
                if (class_exists($class)) {
                    $this["Dao_{$daoName}"] = new $class;
                }
            }
        }
    }
}