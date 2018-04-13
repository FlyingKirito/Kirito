<?php

namespace Kirito\Component;

use PHPunit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    protected $kernel;

    public function setUp()
    {
        parent::setUp();
        $this->kernel = include dirname(__DIR__) . '/../bootstrap/bootstrap_test.php';
        $this->emptyDatabase();
        $this->emptyCache();
    }

    private function emptyDatabase()
    {
        $dbConnect = $this->kernel['db'];
        $tables = $dbConnect->getSchemaManager()->listTableNames();
        $truncateSql = 'TRUNCATE TABLE %s';
        foreach ($tables as $table) {
            $dbConnect->exec(sprintf($truncateSql, $table));
        }
    }

    private function emptyCache()
    {
        $this->kernel['redis']->flushAll();
    }
}