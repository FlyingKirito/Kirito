<?php

namespace Kirito\Controller;

class TestViewController extends BaseController
{
    public function view()
    {
	var_dump(123);
        return $this->render('test.html.twig', []);
    }

    public function testRedirect()
    {
        var_dump($this->redirect('http://www.baidu.com', true));
    }
}
