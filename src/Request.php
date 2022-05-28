<?php

namespace Core;

class Request
{
    protected array $body;
    protected array $query;
    protected string $path;
    protected string $method;

    public function __construct()
    {
        $this->initGlobals();
    }

    public function path(): string
    {
        return $this->path;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function get(string $name): ?string
    {
        if ($this->method === Router::GET) {
            return $this->query[$name] ?? null;
        }

        return $this->body[$name] ?? null;
    }

    protected function initGlobals(): void
    {
        $this->path = $_SERVER['PATH_INFO'] ?? '/';
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->body = $this->normalize($_POST);
        $this->query = $this->normalize($_GET);
    }

    protected function normalize(array $values): array
    {
        foreach ($values as $key => $value) {
            if ('' === $value) {
                $values[$key] = null;
            }
        }

        return $values;
    }
}
