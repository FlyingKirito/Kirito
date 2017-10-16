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
    const RPC_URL = '%s?service=%s';

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

    public function rpc($endpoint, $service)
    {
        if (empty($service)) {
            throw new \Exception('rpc调用：　service参数不能为空');
        }

        $config = $this->config('rpc');
        if (empty($config[$endpoint])) {
            throw new \Exception("rpc调用：　{$endpoint}该站点未有相关配置信息");
        }

        return new \Yar_Client(sprintf(self::RPC_URL, $config[$endpoint], $service));
    }

    public function config($key)
    {
        return $this->config[$key];
    }

    private function init()
    {
        $this->app = new Micro();
        $this->registers();
        return $this->app;
    }

    private function registers()
    {
        $this->registerDatabase();
        $this->registerViewsTemplate();
        $this->registerControllers();
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
            $this["Service_{$name}"] = function ($kernel) use ($class){
                $service = new $class;
                $service->setKernel($kernel);
                return $service;
            };

            return $this["Service_{$name}"];
        }

        return ;
    }

    private function registerDao($name)
    {
        $class = __NAMESPACE__.'\\Dao\\Implement\\'.ucfirst($name).'Impl';
        if (class_exists($class)) {
            $this["Dao_{$name}"] = function ($kernel) use ($class) {
                $dao = new $class;
                $dao->setKernel($kernel);
                return $dao;
            };

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
        $this['views'] = function ($kernel) {
            return new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__.'/Resources/views'), [
                'debug' => true,
            ]);
        };
    }

    private function createDatabase()
    {
        $databaseConfig = $this->config['database']['default'];
        $this['db'] = function () use ($databaseConfig) {
            return DriverManager::getConnection([
                'dbname' => $databaseConfig['database'],
                'user' => $databaseConfig['user'],
                'password' => $databaseConfig['pass'],
                'host' => $databaseConfig['host'],
                'driver' => $databaseConfig['driver']
            ]);
        };
    }

    private function createRedis()
    {
        $redisConfig = $this->config['redis']['default'];
        $this['redis'] = function () use ($redisConfig) {
            $redis = new \Redis();
            $redis->connect($redisConfig['host'], $redisConfig['port']);
            return $redis;
        };
    }
}