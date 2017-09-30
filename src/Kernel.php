<?php

namespace Kirito;

use Doctrine\DBAL\DriverManager;
use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;
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

        return $this->registerService($name);
    }

    public function dao($name)
    {
        $key = sprintf(self::DAO_KEY, $name);
        if($this->offsetExists($key)) {
            return $this[$key];
        }

        return $this->registerDao($name);
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
        $this->registerDatabase();
        $this->registerViewsTemplate();
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
            $response = new Response();
            $response->setStatusCode(200);
            $response->setContent('Welcome to Flying Kirito !');
            return $response;
        });

        $this->app->notFound(function () {
            $response = new Response();
            $response->setStatusCode(404);
            $response->setContent('404 File not found');
            return $response;
        });

        return $collection;
    }

    //对于普通的nginx访问用到再去注册会更好，　但用与其进程的做法还是直接全部注册好
    private function registerService($name)
    {
        $class = __NAMESPACE__.'\\Service\\Implement\\'.ucfirst($name).'Impl';
        if (class_exists($class)) {
            $service = new $class;
            $service->setKernel($this);
            $this["Service_{$name}"] = $service;
            return $this["Service_{$name}"];
        }

        return ;
    }

    private function registerDao($name)
    {
        $class = __NAMESPACE__.'\\Dao\\Implement\\'.ucfirst($name).'Impl';
        if (class_exists($class)) {
            $dao = new $class;
            $dao->setKernel($this);
            $this["Dao_{$name}"] = $dao;
            return $this["Dao_{$name}"];
        }

        return ;
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
        $redisConfig = $this->config['redis']['default'];
        $redis = new \Redis();
        $redis->connect($redisConfig['host'], $redisConfig['port']);
        $this['redis'] = $redis;
    }
}