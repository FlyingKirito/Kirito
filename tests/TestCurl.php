<?php

class TestCurl extends Kirito\Server\UnitTest
{
    public function testGet()
    {
        $start = time();
        try {
            $result = $this->getCurl()
                ->get('www.baidu.com?a=1');
        } catch (\Exception $exception) {
            $end = time();
            var_dump($end - $start);
            var_dump($exception->getMessage());
        }


        var_dump($result);
    }

    private function getCurl()
    {
        return $this->kernel['curl'];
    }
}