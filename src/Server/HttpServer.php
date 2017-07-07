<?php

namespace Kirito\Server;

class HttpServer
{
    private $server;

    public function handle()
    {
        $this->init();
    }

    protected function init()
    {
        $this->server = new swoole_http_server('127.0.0.1', '9271');
        $this->server->on('request', function ($request, $response) {
            $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
        });
        $this->server->start();
    }
}