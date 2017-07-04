<?php

namespace Kirito\Service\Implement;

use Kirito\Service\TestDbService;

class TestDbServiceImpl extends BaseServiceImpl implements TestDbService
{
    public function test()
    {
//        var_dump($this->kernel);
    }

    private function getTestDbDao()
    {
        return $this->kernel->dao('TestDbDao');
    }
}