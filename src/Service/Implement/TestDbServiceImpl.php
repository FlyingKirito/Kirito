<?php

namespace Kirito\Service\Implement;

use Kirito\Service\TestDbService;

class TestDbServiceImpl implements TestDbService
{
    public function test()
    {
        echo 'I am from Service';
    }
}