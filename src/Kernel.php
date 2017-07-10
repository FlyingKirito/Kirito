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
        return $this->init();
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

    public function config($key)
    {
        return $this->config[$key];
    }

    private function init()
    {
        $this->app = new Micro();
        $this->registers();
        return $this->app->handle();
    }

    private function registers()
    {
        $this->registerControllers();
        $this->registerBusiness();
        $this->registerDatabase();
        $this->registerViewsTemplate();
        $this->registerServices();
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

    private function registerBusiness()
    {
        $register = $this->config['business'];

        if (!empty($register['services'])) {
            foreach ($register['services'] as $serviceName) {
                $class = __NAMESPACE__.'\\Service\\Implement\\'.ucfirst($serviceName).'Impl';
                if (class_exists($class)) {
                    $service = new $class;
                    $service->setKernel($this);
                    $this["Service_{$serviceName}"] = $service;
                }
            }
        }
        if (!empty($register['daos'])) {
            foreach ($register['daos'] as $daoName) {
                $class = __NAMESPACE__.'\\Dao\\Implement\\'.ucfirst($daoName).'Impl';
                if (class_exists($class)) {
                    $dao = new $class;
                    $dao->setKernel($this);
                    $this["Dao_{$daoName}"] = $dao;
                }
            }
        }
    }

    private function registerDatabase()
    {
        $this->createDatabase();
        $this->createRedis();
    }

    private function registerViewsTemplate()
    {
        $this['views'] = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__.'/Resources/views'), [
            'debug' => true,
        ]);
    }

    private function registerServices()
    {

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