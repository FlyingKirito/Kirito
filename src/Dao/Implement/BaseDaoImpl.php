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
        return $this->db()->insert($this->table, $fields);
    }

    public function update($id, $fields)
    {
        return $this->db()->update($this->table, $fields, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db()->delete($this->table, array('id' => $id));
    }

    public function count($conditions)
    {
        $andWheres = $this->andWhere($conditions);
        $sql = "SELECT COUNT(*) AS `count` FROM {$this->table} ".(empty($andWheres)? '' : 'WHERE '.$andWheres);
        return $this->db()->fetchAssoc($sql, array_values($conditions));
    }

    public function search($conditions, $orderBy, $start, $limit)
    {
        
    }

    private function andWhere($wheres)
    {
         return implode(' = ? AND', array_keys($wheres)).' = ?';
    }
}