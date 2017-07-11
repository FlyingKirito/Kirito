<?php

namespace Kirito\Server;

class HttpServer
{
    private $server;
    private $kernel;

    private $bind = ['onRequest' => 'request'];

    public function handle()
    {
        $this->init();
    }

    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    private function init()
    {
        $this->createServer();
        $this->bind();
        $this->start();
    }

    private function createServer()
    {
        $config = $this->kernel->config('httpServer');
        $this->server = new \swoole_http_server($config['host'], $config['port']);
        $this->server->set($config['setting']);
    }

    private function start()
    {
        $this->server->start();
    }

    private function bind()
    {
        foreach ($this->bind as $function => $event) {
            $this->server->on($event, [$this, $function]);
        }
    }

    public function onRequest($req, $res)
    {
        if ($req->server['request_uri'] == '/favicon.ico') {
            return ;
        }

        $_GET = $_POST = $_SERVER = $_COOKIE = [];

        $_GET = !empty($req->get) ? $req->get : [];
        $_POST = !empty($req->post) ? $req->post : [];

        $_GET['_url'] = $_SERVER['REQUEST_URI'] = $req->server['request_uri'];
        $_SERVER['REQUEST_METHOD'] = $req->server['request_method'];
        $_COOKIE = $req->cookie;

        ob_start();
        $response = $this->kernel->boot();
        ob_end_clean();
        $res->end($response);
    }
}
