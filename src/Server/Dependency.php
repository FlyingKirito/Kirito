<?php

namespace Kirito\Server;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;

class Dependency
{
    private $di;

    public function __construct()
    {
        $this->di = new FactoryDefault;
    }

    public function initView()
    {
        $this->di->set('view', function () {
            $view = new View();
            $view->setViewsDir(dirname(__DIR__)."/Views/");

            return $view;
        });
    }

    public function getDi()
    {
        return $this->di;
    }
}
