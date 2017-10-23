<?php

class TestRpcServiceTest extends \Kirito\Server\UnitTest
{
    public function testGetAccount()
    {
        $account = $this->getTestRpcService()->getAccount();
    }

    private function getTestRpcService()
    {
        return $this->kernel->service('TestRpcService');
    }
}