<?php



return [
    'TestViewController' => [
        'prefix' => '/v1/kirito/view',
        'routes' => [
            ['route' => '/say/hello', 'method' => 'get', 'action' => 'view'],
        ]
    ],
    'TestDbController' => [
        'prefix' => '/v1/kirito/db',
        'routes' => [
            ['route' => '/test/create', 'method' => 'post', 'action' => 'testCreate'],
            ['route' => '/test/update', 'method' => 'post', 'action' => 'testUpdate'],
            ['route' => '/test/get/{id}', 'method' => 'get', 'action' => 'testGet'],
            ['route' => '/test/delete/{id}', 'method' => 'get', 'action' => 'testDelete'],
            ['route' => '/test/count', 'method' => 'get', 'action' => 'testCount']
        ]
    ],
    'TestSocketController' => [
        'prefix' => '/v1/kirito/socket',
        'routes' => [
            ['route' => '/test/connect', 'method' => 'get', 'action' => 'testSocket']
        ]
    ]
];
