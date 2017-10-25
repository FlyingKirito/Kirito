<?php

namespace Kirito\Controller;

class UserController extends BaseController
{
    public function login()
    {
        //判断验证还是跳转到本页面
        if ($this->requestMethod() == 'GET') {
            $csrfToken = md5(microtime().uniqid());
            $_SESSION['_csrf_token'] = $csrfToken;

            return $this->render('login/index.html.twig', [
                'csrf_token_key' => $this->security->getTokenKey(),
                'csrf_token' => $this->security->getToken()
            ]);
        }

        if ($this->csrfTokenValid()) {

        }
    }
}