<?php

class TestDbServiceTest extends \Kirito\Server\UnitTest
{
    public function testTranslation()
    {
        $this->getTestDbService()->testTranscation();
    }

    private function getTestDbService()
    {
        return $this->kernel->service('TestDbService');
    }
}