<?php

namespace Core;

class Response
{
    public const STATUS_OK = 200;
    public const STATUS_NOT_FOUND = 404;
    protected string $content;

    public function __construct(string $content, int $code)
    {
        $this->content = $content;
        $this->setCode($code);
    }

    public static function ok(string $content): self
    {
        return new self($content, self::STATUS_OK);
    }

    public static function notFound(string $content): self
    {
        return new self($content, self::STATUS_NOT_FOUND);
    }

    public function send(): void
    {
        echo $this->content;
    }

    protected function setCode(int $code): void
    {
        http_response_code($code);
    }
}
