<?php

namespace Kirito\Service\Implement;

use Doctrine\DBAL\DriverManager;
use Kirito\Dao\Implement\TestDbDaoImpl;
use Kirito\Service\TestDbService;
use Symfony\Component\Config\Definition\Exception\Exception;

class TestDbServiceImpl extends BaseServiceImpl implements TestDbService
{
    public function testCreate($fields)
    {
        var_dump($this->getTestDbDao()->create($fields));
    }

    public function testGet($id)
    {
        return $this->getTestDbDao()->get($id);
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

    public function testTranscation()
    {
        $dao = $this->getTestDbDao();
        try {
            $dao->db()->beginTransaction();
            $dao->create([
                'name' => 'test',
                'age' => 18
            ]);
            $this->getOtherDao()->insert('test', [
                'name' => 'test',
                'age' => '19'
            ]);
            $dao->db()->commit();

        } catch (\Exception $e) {
            var_dump($e->getMessage());
            $dao->db()->rollBack();

        }
    }

    private function getTestDbDao()
    {
        return $this->kernel->dao('TestDbDao');
    }

    private function getOtherDao()
    {

        $databaseConfig = $this->kernel->config('database')['default'];
        return DriverManager::getConnection([
            'dbname' => $databaseConfig['database'],
            'user' => $databaseConfig['user'],
            'password' => $databaseConfig['pass'],
            'host' => $databaseConfig['host'],
            'driver' => $databaseConfig['driver']
        ]);
    }
}