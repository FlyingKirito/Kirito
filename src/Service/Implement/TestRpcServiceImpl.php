<?php

namespace Kirito\Service\Implement;

use Kirito\Service\TestRpcService;

class TestRpcServiceImpl extends BaseServiceImpl implements TestRpcService
{
    public function getAccount()
    {
//        return $this->getAccountRpc()->findAccounts();
    }

    public function getAccountRpc()
    {
        return $this->kernel->rpc('im_api', 'Account:AccountService');
    }
}