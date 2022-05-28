<?php

namespace Core\Controllers;

use Core\App;
use Core\RedirectResponse;
use Core\Response;

abstract class Controller
{
    protected App $app;

    public function __construct()
    {
        $this->app = App::app();
    }

    protected function render(string $view, array $data = []): Response
    {
        return Response::ok($this->app->render($view, $data));
    }

    protected function redirect(string $url): RedirectResponse
    {
        return new RedirectResponse($url);
    }
}
