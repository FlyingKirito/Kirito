<?php

namespace Kirito\Service\Implement;

use Kirito\Service\UserService;

class UserServiceImpl extends BaseServiceImpl implements UserService
{
    public function login($username, $password)
    {
        //查找用户
        $user = $this->getUser($username);
        //验证及设置session
        if ($this->checkPassword($password, $user)) {
            $this->
        }

        //返回

    }

    public function register($params)
    {

    }

    public function logout($userId)
    {

    }

    private function getUser($username)
    {
        $user = $this->getUserDao()->getByUsername($username);
        if ($user) {
            //报错没有用户
        }

        return $user;
    }

    private function checkPassword($password, $user)
    {
        $hashPassword = md5(hash_hmac('sha1', $password, $user['salt'], true));
        if ($hashPassword == $user['password']) {
            return true;
        }

        return false;
    }

    private function getUserDao()
    {
        return $this->kernel->dao('UserDao');
    }
}