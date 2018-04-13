<?php

namespace Kirito;

use Doctrine\DBAL\DriverManager;
use Kirito\Component\IdGenerator;
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
        $this->handle();
    }

    private function handle()
    {
        $this->app->get('/', function () {
            echo 'Welcome to Flying Kirito !';
        });
        $this->app->notFound(function () {
            echo '404 File not found';
        });

        ob_start();
        $response = $this->app->handle();
        ob_end_clean();
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
                $collection->{$route['method']}($route['route'], $route['method']);
            }
            $this->app->mount($collection);
        }

        return $collection;
    }

    private function registers()
    {
        $this->registerControllers();
        $this->registerDatabase();
        $this->registerComponent();
    }

    private function registerDatabase()
    {
        $this->createDatabase();
        $this->createRedis();
    }

    private function createDatabase()
    {
        $databaseConfig = $this->config['database']['default'];
        $this['db'] = function () use ($databaseConfig) {
            return DriverManager::getConnection([
                'dbname' => $databaseConfig['dbname'],
                'user' => $databaseConfig['user'],
                'password' => $databaseConfig['pass'],
                'host' => $databaseConfig['host'],
                'driver' => $databaseConfig['driver']
            ]);
        };
    }

    private function createRedis()
    {
        $config = $this->config['redis'];
        $this['redis'] = function () use ($config) {
            $redis = new \Redis();
            $redis->connect($config['host'], $config['port']);
            return $redis;
        };
    }

    private function registerComponent()
    {
        $this['id_generator.uuid'] = function () {
            return new IdGenerator();
        };
    }

}