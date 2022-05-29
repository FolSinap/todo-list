<?php

namespace Core;

class Route
{
    public const GET = 'GET';
    public const POST = 'POST';
    protected string $url;
    protected $callback;
    protected string $method;
    protected array $wildcards = [];

    public function __construct(string $url, $callback, string $method)
    {
        $this->url = $url;
        $this->callback = $callback;
        $this->method = $method;
    }

    public function getCallback(): callable
    {
        $callback = $this->callback;

        if (is_array($callback)) {
            $controller = new $callback[0]();
            $method = $callback[1];

            return function () use ($controller, $method) {
                return $controller->$method(...$this->wildcards);
            };
        }

        return function () use ($callback) {
            return $callback(...$this->wildcards);
        };
    }

    public function match(string $url, string $method): bool
    {
        return $this->method === $method && $this->matchUrl($url);
    }

    public function matchUrl(string $url): bool
    {
        if ($url === $this->url) {
            return true;
        }

        $parsedSelf = $this->parseUrl($this->url);
        $parsedMatched = $this->parseUrl($url);

        if (count($parsedSelf) !== count($parsedMatched)) {
            return false;
        }

        foreach ($parsedSelf as $position => $part) {
            if (($part === '' && $position === 0) || ($part === $parsedMatched[$position])) {
                continue;
            } elseif ($this->isWildcard($part)) {
                $this->wildcards[] = $parsedMatched[$position];

                continue;
            }

            return false;
        }

        return true;
    }

    protected function parseUrl(string $url): array
    {
        return explode('/', $url);
    }

    protected function isWildcard(string $urlPart): bool
    {
        return str_starts_with($urlPart, '{') && str_ends_with($urlPart, '}');
    }
}
