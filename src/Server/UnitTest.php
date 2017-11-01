<?php

namespace Kirito\Server;

class UnitTest extends \PHPUnit_Framework_TestCase
{
    protected $kernel;

    public function setUp()
    {
        parent::setUp();
        $this->kernel = include dirname(__DIR__).'/../bootstrap/bootstrap_testing.php';
    }

    public function getKernel()
    {
        return $this->kernel;
    }
}