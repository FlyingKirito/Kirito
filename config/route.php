<?php



return [
    'Test1Controller' => [
        'prefix' => '/v1/kirito/test1',
        'routes' => [
            ['route' => '/say/hello/{name}', 'method' => 'get', 'action' => 'get'],
            ['route' => '/say/hello/{name}', 'method' => 'post', 'action' => 'post']
        ]
    ],
    'Test2Controller' => [
        'prefix' => '/v1/kirito/test2',
        'routes' => [
            ['route' => '/say/bye/{name}', 'method' => 'get', 'action' => 'get'],
            ['route' => '/say/bye/{name}', 'method' => 'post', 'action' => 'post']
        ]
    ],
];
