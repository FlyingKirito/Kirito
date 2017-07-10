<?php

namespace Kirito\Controller;

class TestViewController extends BaseController
{
    public function view()
    {
        return $this->render('test.html.twig', []);
    }
}