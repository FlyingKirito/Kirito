<?php

namespace Kirito\Server;

class HttpServer
{
    private $server;
    private $kernel;

    public function handle()
    {
        $this->init();
    }

    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    protected function init()
    {
        $this->server = new \swoole_http_server('127.0.0.1', '9271');
        $this->server->on('request', function ($req, $res) {
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
        });
        $this->server->start();
    }

}
