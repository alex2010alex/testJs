<?php

$config = [
    'host' => 'localhost',
    'dbName' => 'testJs',
    'charset' => 'utf8',
    'user' => 'root',
    'passwd' => '',
    'salt' => 'R@ndomT3xt'
];

$config['dsn'] = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbName'] . ';charset=' . $config['charset'];
