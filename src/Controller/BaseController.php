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
}