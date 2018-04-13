<?php

namespace Kirito\Service\Implement;

class BaseServiceImpl
{
    protected $kernel;

    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    protected function getValidator()
    {
        return $this->kernel['validator'];
    }
}