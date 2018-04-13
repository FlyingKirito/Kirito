<?php

namespace Kirito\Server;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;

class Handler
{
    protected $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    public function handle()
    {
        $this->init();

        $this->app->get('/', function () {
            echo 'Welcome to Flying Kirito !';
        });
        $this->app->notFound(function () {
            echo '404 File not found';
        });

        ob_start();
        $response = $this->app->handle();
        ob_end_clean();
        if (!$response instanceof \Phalcon\Http\Response) {
            echo 'not expect response!';
            exit;
        }

        return $response->send();
    }

    private function init()
    {
        $this->app = new Micro();
        $this->registerControllers();
    }

    private function registerControllers()
    {
        $collection = new Collection();

        $controllersRoutes = $this->kernel->config('route');
        foreach ($controllersRoutes as $controllerName => $routes) {
            $className = __NAMESPACE__.'\\Controller\\'.ucfirst($controllerName);
            $controller = new $className();
            $controller->setKernel($this);
            $collection->setHandler($controller);
            $collection->setPrefix($routes['prefix']);
            foreach ($routes['routes'] as $route) {
                $collection->{$route['method']}($route['route'], $route['method']);
            }
            $this->app->mount($collection);
        }
    }
}