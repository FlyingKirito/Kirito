<?php

namespace Kirito\Dao;

interface BaseDao
{
    public function get($id);

    public function create($fields);

    public function update($id, $fields);

    public function delete($id);

    public function count($conditions);

    public function search($conditions, $orderBy, $start, $limit);
}