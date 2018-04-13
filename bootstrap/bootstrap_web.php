<?php

$kernel = include dirname(__DIR__).'/bootstrap/bootstrap_kernel.php';

$server = new \Kirito\Server\Handler($kernel);
$server->handle();