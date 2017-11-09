<?php

namespace Kirito\Service;

interface UserService
{
    public function login($username, $password);

    public function register($params);

    public function logout($userId);
}