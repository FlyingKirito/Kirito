<?php

use Phpmig\Adapter;
use Pimple\Container;

$container = new Container();

$config = include __DIR__ . '/config/parameters.php';
$dbConfig = $config['database']['default'];

$container['db'] = function () use ($dbConfig) {
    $dbh = new PDO("mysql:dbname={$dbConfig['dbname']};host={$dbConfig['host']}", $dbConfig['user'], $dbConfig['pass']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
};

$container['phpmig.adapter'] = function ($c) {
    return new Adapter\PDO\Sql($c['db'], 'migrations');
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;
