<?php

namespace Kirito\Controller;

use Phalcon\Mvc\Controller;

class Test1Controller extends Controller
{
    public function get($name)
    {
        echo 123;
    }

    public function post()
    {
        echo 456;
    }
}