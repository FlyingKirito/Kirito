<?php

namespace Kirito\Service;

interface UserService
{
    public function login($params);

    public function register($params);

    public function logout($userId);
}