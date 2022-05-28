<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = Core\App::app();
$router = $app->router();

$router->get('/', function () {
    return '1213qweq';
});
$router->get('/qwe', function () {
    return 'qwe';
});

$app->run();
