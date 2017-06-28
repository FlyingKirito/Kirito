<?php

namespace Kirito\Controller;

class TestRouteController extends BaseController
{
    public function get()
    {
        $params = $this->request->get('a');
        var_dump($params);
    }

    public function post()
    {
        $params['get'] = $this->request->get('a');
        $params['post'] = $this->request->getPost('b');
        var_dump($params);
    }
}