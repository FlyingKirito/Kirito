<?php

namespace Kirito\Controller;

class TestSocketController extends BaseController
{
    public function testSocket()
    {
        return $this->render('socket.html.twig', []);
    }
}