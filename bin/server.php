#!/usr/bin/php
<?php

class Server
{
    private $argv;
    private $argc;

    private $command = ['start', 'stop'];

    public function __construct($argv, $argc)
    {
        $this->argv = $argv;
        $this->argc = $argc;
    }

    public function boot()
    {
        $this->init();
    }

    private function init()
    {
        if (empty($this->checkCommand())) {
            return;
        }

        $server = $this->createServer();
        $server->handle();
    }

    private function checkCommand()
    {
        if ($this->argc != 3) {
            echo 'Parameter format error [server command(start|stop) configPath]';
            return;
        }

        if (!in_array($this->argv[1], $this->command)) {
            echo 'command error! [start|stop]';
            return;
        }

        if (!file_exists($this->argv[2])) {
            echo 'config file missing';
            return;
        }

        return true;
    }

    private function createServer()
    {
        return include $this->argv[2];
    }
}

$server = new Server($argv, $argc);
$server->boot();