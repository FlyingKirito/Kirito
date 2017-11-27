<?php

namespace Kirito\Business;

use Doctrine\DBAL\DriverManager;

class MysqlPool
{
    protected $kernel;

    private $freeConnectQueue;
    private $busyConnectQueue;
    private $maxConnects;
    private $minConnects;
    private $nowConnects;
    private $freeConnects;
    private $config;

    public function __construct()
    {
        $this->freeConnectQueue = new \SplQueue();
        $this->busyConnectQueue = new \SplQueue();
        $this->maxConnects = 20;
        $this->minConnects = 5;
        $this->nowConnects = 0;
        $this->freeConnects = 0;
    }

    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
        $this->config = $this->kernel->config('database');
    }

    public function setMaxConnects($maxConnects)
    {
        $this->maxConnects = $maxConnects;
    }

    public function setMinConnects($minConnects)
    {
        $this->minConnects = $minConnects;
    }

    public function boot()
    {
        $this->init();
    }

    public function getConnect()
    {
        if ($this->nowConnects < $this->minConnects) {
            $this->createDatabaseConnects();
        }

        if ($this->freeConnects > 0) {
            return $this->dispatchFreeConnects();
        }

        if ($this->nowConnects < $this->maxConnects) {
            return $this->addConnects();
        }

        return 'mysql pool busy!';
    }

    public function releaseConnect($connect)
    {
        $this->busyConnectQueue->dequeue();
        $this->freeConnectQueue->enqueue($connect);
        $this->freeConnects ++;
    }

    private function init()
    {
        $this->createDatabaseConnects();
    }

    private function dispatchFreeConnects()
    {
        $connect = $this->freeConnectQueue->dequeue();
        $this->busyConnectQueue->enqueue($connect);
        $this->freeConnects --;
        return $connect;
    }

    private function addConnects()
    {
        $connect = $this->createConnect();
        $this->busyConnectQueue->enqueue($connect);
        $this->nowConnects ++;
        return $connect;
    }

    private function createDatabaseConnects()
    {
        for ( ; $this->nowConnects < $this->minConnects; $this->nowConnects ++) {
            $this->freeConnectQueue->enqueue($this->createConnect());

            $this->freeConnects ++;
        }
    }

    private function createConnect()
    {
        $config = $this->config;
        return function () use ($config) {
            return DriverManager::getConnection([
                'dbname' => $config['database'],
                'user' => $config['user'],
                'password' => $config['pass'],
                'host' => $config['host'],
                'driver' => $config['driver']
            ]);
        };
    }
}