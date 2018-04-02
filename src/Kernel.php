<?php

namespace Kirito;

use Doctrine\DBAL\DriverManager;
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

        $serviceName = __NAMESPACE__.'\\Service\\Implement\\'.ucfirst($name).'Impl';
        $service = new $serviceName;
        $service->setKernel($this);

        $this[$key] = $service;
        return $service;
    }

    public function dao($name)
    {
        $key = sprintf(self::DAO_KEY, $name);
        if($this->offsetExists($key)) {
            return $this[$key];
        }

        $daoName = __NAMESPACE__.'\\Dao\\Implement\\'.ucfirst($name).'Impl';
        $dao = new $daoName;
        $dao->setKernel($this);

        $this[$key] = $dao;
        return $dao;
    }

    public function config($key)
    {
        return $this->config[$key];
    }

    private function init()
    {
        $this->app = new Micro();
        $this->registers();
        $this->app->handle();
    }

    private function registerControllers()
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
        $this->registerControllers();
        $this->registerDatabase();
    }

    private function registerDatabase()
    {
        $this->createDatabase();
        $this->createRedis();
    }

    private function createDatabase()
    {
        $databaseConfig = $this->config['database']['default'];
        $this['db'] = DriverManager::getConnection([
            'dbname' => $databaseConfig['database'],
            'user' => $databaseConfig['user'],
            'password' => $databaseConfig['pass'],
            'host' => $databaseConfig['host'],
            'driver' => $databaseConfig['driver']
        ]);
    }

    private function createRedis()
    {

    }

}