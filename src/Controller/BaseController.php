<?php

namespace Kirito\Controller;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class BaseController extends Controller
{
    protected $kernel;

    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    protected function getQuery()
    {
        $get = empty($this->request->get()) ? $_GET : $this->request->get();
        return empty($get) ? [] : $get;
    }

    protected function getPost()
    {
        $post = empty($this->request->getPost()) ? $_POST : $this->request->getPost();
        return empty($post) ? [] : $post;
    }

    protected function render($path, $fields)
    {
        return $this->kernel['views']->render($path, $fields);
    }

    protected function redirect($url, $isOutside)
    {
        $response = new Response();
        return $response->redirect($url, $isOutside);
    }

    protected function jsonReturn($params)
    {
        $response = new Response();
        $response->setStatusCode(200);
        return $response->setJsonContent($params);
    }
}