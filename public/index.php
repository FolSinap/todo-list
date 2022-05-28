<?php

use Core\App;
use Core\Controllers\AuthController;
use Core\Controllers\TaskController;

require_once dirname(__DIR__) . '/vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__))->load();

$app = new App(dirname(__DIR__));
$router = $app->router();

$router->get('/', [TaskController::class, 'index']);
$router->get('/tasks/create', [TaskController::class, 'create']);
$router->post('/tasks/create', [TaskController::class, 'store']);
$router->get('/login', [AuthController::class, 'index']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$app->run();
