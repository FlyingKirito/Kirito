<?php

namespace Kirito\Controller;

use Phalcon\Mvc\Controller;

class Test2Controller extends Controller
{
    public function get($name)
    {
        echo 2222;
    }

    public function post()
    {
        echo 3333;
    }
}