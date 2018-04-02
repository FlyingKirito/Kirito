<?php

namespace Kirito\Dao\Implement;

use Kirito\Dao\TestDbDao;

class TestDbDaoImpl extends BaseDaoImpl implements TestDbDao
{
    protected $table = 'test';

    public function getByNo($no)
    {

    }
}