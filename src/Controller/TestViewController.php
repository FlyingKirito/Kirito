<?php

namespace Kirito\Controller;

class TestViewController extends BaseController
{
    public function view()
    {
        return $this->render('test.html.twig', []);
    }

    public function testRedirect()
    {
        var_dump($this->redirect('http://www.baidu.com', true));
    }
}
