<?php

namespace Kirito\Controller;

class TestViewController extends BaseController
{
    public function view()
    {
        $this->render('test.html.twig', []);
    }
}