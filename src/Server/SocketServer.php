<?php

namespace Kirito\Server;

class SocketServer
{
    private $kernel;
    private $server;
    private $events = [
        'onOpen' => 'open',
        'onMessage' => 'message',
        'onClose' => 'close'
    ];

    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    public function handle()
    {
        $this->init();
    }

    private function init()
    {
        $this->createServer();
        $this->bind();
        $this->start();
    }

    private function createServer()
    {
        $config = $this->kernel->config('socketServer');
        $this->server = new \swoole_websocket_server($config['host'], $config['port']);
        $this->server->set($config['setting']);
    }

    public function onOpen($server, $request)
    {
        echo "server: socket open success {$request->fd}!";
    }

    public function onMessage($server, $frame)
    {
        echo "receive: message {$frame->data} from {$frame->fd} serverFd: {$server->fd}";
        $server->push($frame->fd, 'I am Kirito');
    }

    public function onClose($server, $fd)
    {
        echo "Socket close {$fd}";
    }

    private function bind()
    {
        foreach ($this->events as $method => $event) {
            $this->server->on($event, [$this, $method]);
        }
    }

    private function start()
    {
        $this->server->start();
    }
}