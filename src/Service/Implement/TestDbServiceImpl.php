<?php

namespace Kirito\Service\Implement;

use Kirito\Service\TestDbService;

class TestDbServiceImpl extends BaseServiceImpl implements TestDbService
{
    public function testCreate($fields)
    {
        var_dump($this->getTestDbDao()->create($fields));
    }

    public function testGet($id)
    {
        var_dump($this->getTestDbDao()->get($id));
    }

    public function testUpdate($id, $fields)
    {
        var_dump($this->getTestDbDao()->update($id, $fields));
    }

    public function testDelete($id)
    {
        var_dump($this->getTestDbDao()->delete($id));
    }

    public function testCount($fields)
    {
        return $this->getTestDbDao()->count($fields);
    }

    private function getTestDbDao()
    {
        return $this->kernel->dao('TestDbDao');
    }
}