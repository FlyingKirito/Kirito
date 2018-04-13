<?php

namespace Kirito\Controller;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class BaseController extends Controller
{
    protected $kernel;
    protected $response;

    public function initialize()
    {
        $this->response = new Response;
    }

    public function view()
    {
        $this->response->setStatusCode(200, 'OK');
        $this->response->setContent('view');
        return $this->response;
    }

    public function jsonReturn($return)
    {
        $this->response->setStatusCode(200, 'OK');
        $this->response->setHeader("Content-Type", "application/json");
        $this->response->setJsonContent($return, JSON_NUMERIC_CHECK);
        return $this->response;
    }

    public function redirect($url)
    {
        $this->response->redirect($url, true, 302);
    }
}