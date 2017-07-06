<?php

namespace Kirito\Controller;

class TestDbController extends BaseController
{
    public function testCreate()
    {
        $params = $this->request->getPost();
        $this->getTestDbService()->testCreate($params);
    }

    public function testUpdate()
    {
        $params = $this->request->getPost();
        $this->getTestDbService()->testUpdate($params['id'], [
            'name' => empty($params['name']) ? '' : $params['name'],
            'age' => empty($params['age']) ? '' : $params['age']
        ]);
    }

    public function testGet($id)
    {
        $this->getTestDbService()->testGet($id);
    }

    public function testDelete($id)
    {
        $this->getTestDbService()->testDelete($id);
    }

    private function getTestDbService()
    {
        return $this->kernel->service('TestDbService');
    }
}