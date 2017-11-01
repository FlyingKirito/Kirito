<?php

namespace Kirito\Service\Implement;

use Kirito\Service\UserService;

class UserServiceImpl extends BaseServiceImpl implements UserService
{
    public function login($params)
    {
        //查找用户
        //验证加密后密码
        //返回
    }

    public function register($params)
    {

    }

    public function logout($userId)
    {

    }
}