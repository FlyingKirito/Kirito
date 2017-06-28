<?php

namespace Kirito\Server\Implement;

use Kirito\Service\TestDbService;

class TestDbServiceImpl implements TestDbService
{
    public function testDb()
    {
        echo 123;
    }
}