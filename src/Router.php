<?php

namespace Core;

class Router
{
    public const GET = 'GET';
    public const POST = 'POST';
    private array $routes;

    public function resolve(string $method, string $uri): callable
    {
        if (array_key_exists($uri, $this->routes) && array_key_exists($method, $this->routes[$uri])) {
            return $this->routes[$uri][$method];
        }

        return function () {
            return 'not found';
        };
    }

    public function get(string $uri, callable $func): void
    {
        $this->routes[$uri][self::GET] = $func;
    }

    public function post(string $uri, callable $func): void
    {
        $this->routes[$uri][self::POST] = $func;
    }
}
