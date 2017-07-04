<?php

namespace Kirito\Dao\Implement;

use Kirito\Dao\BaseDao;

class BaseDaoImpl implements BaseDao
{
    protected $kernel;
    protected $table;

    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    protected function db()
    {
        return $this->kernel['db'];
    }

    public function get($id)
    {

    }

    public function create($fields)
    {

    }

    public function update($id, $fields)
    {

    }

    public function delete($id)
    {

    }

    public function count($conditions)
    {

    }

    public function search($conditions, $orderBy, $start, $limit)
    {

    }
}