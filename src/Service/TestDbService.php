<?php

namespace Kirito\Service;

interface TestDbService
{
    public function testDelete($id);

    public function testGet($id);

    public function testCreate($fields);

    public function testUpdate($id, $fields);

    public function testCount($fields);
}