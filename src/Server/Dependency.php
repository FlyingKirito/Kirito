<?php

namespace Kirito\Server;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\http\Request;

class Dependency
{
    private $di;

    public function __construct()
    {
        $this->di = new FactoryDefault;
    }

    public function getDI()
    {
        return $this->di;
    }

    public function init()
    {
        $this->initRequest();
        $this->initView();
    }

    private function initRequest()
    {
        $this->di->set('request', new Request());
    }

    private function initView()
    {
        $this->di->set('view', function () {
            $view = new View();
            $view->setViewsDir(dirname(__DIR__)."/Views/");

            return $view;
        });
    }
}
