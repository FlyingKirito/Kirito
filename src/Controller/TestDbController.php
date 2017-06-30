<?php

namespace Kirito\Controller;

class TestDbController extends BaseController
{
    public function test($value)
    {
        $this->kernel->service('TestDbService')->test();
    }

    private function getTestDbService()
    {
        return $this->kernel->service('TestDbService');
    }
}