<?php

namespace Core;

class Router
{
    public const GET = 'GET';
    public const POST = 'POST';
    private array $routes;

    public function resolve(string $method, string $uri): callable
    {
        if ($route = $this->findRoute($uri, $method)) {
            return $route->getCallback();
        }

        return function () {
            return 'not found';
        };
    }

    public function get(string $uri, callable $func): void
    {
        $this->addRoute($uri, Route::GET, $func);
    }

    public function post(string $uri, callable $func): void
    {
        $this->addRoute($uri, Route::POST, $func);
    }

    public function findRoute(string $url, string $verb): ?Route
    {
        foreach ($this->routes as $route) {
            if ($route->match($url, $verb)) {
                return $route;
            }
        }

        return null;
    }

    protected function addRoute(string $url, string $method, $callback): void
    {
        $this->routes[] = new Route($url, $callback, $method);
    }
}
