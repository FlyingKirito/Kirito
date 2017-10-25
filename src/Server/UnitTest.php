<?php

namespace Kirito\Server;

class UnitTest extends \PHPUnit_Framework_TestCase
{
    protected $kernel;

    public function setUp()
    {
        parent::setUp();
        $config = include dirname(__DIR__).'../../config/parameters-testing.php';
        $this->kernel = new \Kirito\Kernel($config);
        $this->kernel->boot();
    }

    public function getKernel()
    {
        return $this->kernel;
    }
}