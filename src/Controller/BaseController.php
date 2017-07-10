<?php

namespace Kirito\Controller;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    protected $kernel;

    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    protected function render($path, $fields)
    {
        return $this->kernel['views']->render($path, $fields);
    }
}