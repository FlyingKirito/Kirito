<?php

namespace Kirito\Controller;

class UserController extends BaseController
{
    public function login()
    {
        //判断验证还是跳转到本页面
        if ($this->requestMethod() == 'GET') {
            $_SESSION['_csrf_token'] = md5(microtime().uniqid());
            return $this->render('login/index.html.twig', [
                'csrf_token_key' => $this->security->getTokenKey(),
                'csrf_token' => $this->security->getToken()
            ]);
        }

        if ($this->csrfTokenValid()) {
            $post = $this->getPost();
            $this->checkPost($post);
            $this->getUserService()->login($post['username'], $post['password']);
        }

        return $this->render('test.html.twig', []);
    }



    private function getUserService()
    {
        return $this->kernel->service('UserService');
    }
}