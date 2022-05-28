<?php

namespace Core;

use DomainException;

class App
{
    private static self $app;
    private Router $router;
    private Request $request;

    private function __construct()
    {
        $this->init();
    }

    public static function app(): self
    {
        if (!isset(self::$app)) {
            self::$app = new self();
        }

        return self::$app;
    }

    public function run()
    {
        $callable = $this->router->resolve($this->request->method(), $this->request->path());
        $response = $callable();

        if (is_string($response)) {
            $response = Response::ok($response);
        } elseif (!$response instanceof Response) {
            throw new DomainException('Router function must return string or ' . Response::class . ' object');
        }

        $response->send();
    }

    public function router(): Router
    {
        return $this->router;
    }

    private function init(): void
    {
        $this->router = new Router();
        $this->request = new Request();
    }
}
