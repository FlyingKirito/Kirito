<?php

namespace Kirito\Server;

use Phalcon\Http\Response;

class HttpServer
{
    private $server;
    private $kernel;
    private $handle;

    private $bind = [
        'onRequest' => 'request',
        'onWorkerStart' => 'workerStart'
    ];

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

    public function onWorkerStart()
    {
        $this->handle = $this->kernel->boot();
    }

    public function onRequest($req, $res)
    {
        if ($req->server['request_uri'] == '/favicon.ico') {
            return ;
        }

        $_GET = $_POST = $_SERVER = $_COOKIE = [];

        $_GET = !empty($req->get) ? $req->get : [];
        $_POST = !empty($req->post) ? $req->post : [];
        $_SERVER = !empty($req->server) ? $req->server : [];

        $_GET['_url'] = $_SERVER['REQUEST_URI'] = $req->server['request_uri'];
        $_COOKIE = isset($req->cookie) ? $req->cookie : [];

        ob_start();
        $response = $this->handle->handle();
        ob_end_clean();

        if ($response instanceof Response) {
            $code = $response->getStatusCode();
            $res->status(intval($code));
            $res->end($response->getContent());
        } else {
            throw new \Exception('Response Error !');
        }
    }
}
