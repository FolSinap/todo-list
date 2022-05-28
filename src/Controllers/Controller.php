<?php

namespace Core\Controllers;

use Core\App;
use Core\Response;

abstract class Controller
{
    protected App $app;

    public function __construct()
    {
        $this->app = App::app();
    }

    public function render(string $view, array $data): Response
    {
        return Response::ok($this->app->render($view, $data));
    }
}
