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
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db()->fetchAssoc($sql, [$id]);
    }

    public function create($fields)
    {
        $fields['createdTime'] = time();
        $fields['updatedTime'] = time();
        $this->db()->insert($this->table, $fields);
    }

    public function update($id, $fields)
    {

    }

    public function delete($id)
    {
        return $this->db()->delete($this->table, array('id' => $id));
    }

    public function count($conditions)
    {

    }

    public function search($conditions, $orderBy, $start, $limit)
    {

    }
}