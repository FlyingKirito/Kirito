<?php

namespace Kirito;

use Doctrine\DBAL\DriverManager;
use Kirito\Component\IdGenerator;
use Pimple\Container;

class Kernel extends Container
{
    private $config;

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