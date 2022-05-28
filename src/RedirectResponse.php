<?php

namespace Core;

class RedirectResponse extends Response
{
    protected string $url;

    public function __construct(string $url = '/', int $code = 301)
    {
        $this->url = $url;

        parent::__construct('', $code);
    }

    public function send(): void
    {
        header("Location: $this->url");
    }
}
