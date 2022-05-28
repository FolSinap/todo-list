<?php

use Core\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__))->load();

$app = new App(dirname(__DIR__));
$router = $app->router();

$router->get('/', [\Core\Controllers\TaskController::class, 'index']);
$router->get('/qwe', function () {
    return 'qwe';
});

$app->run();
