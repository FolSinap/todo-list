<?php

namespace Core;

use DomainException;
use PDO;

class App
{
    protected static self $app;
    protected string $projectDir;
    protected Router $router;
    protected Request $request;
    protected PDO $pdo;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
        self::$app = $this;

        $this->init();
    }

    public static function app(): self
    {
        return self::$app;
    }

    public function getProjectDir(): string
    {
        return $this->projectDir;
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

    public function render(string $view, array $data = []): string
    {
        $layout = $this->includeFrom($this->projectDir . '/templates/layout.php');
        $view = $this->includeFrom($this->projectDir . '/templates/' . $view . '.php', $data);

        return str_replace('{{content}}', $view, $layout);
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function request(): Request
    {
        return $this->request;
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }

    protected function includeFrom(string $view, array $data = []): string
    {
        foreach ($data as $key => $val) {
            $$key = $val;
        }

        ob_start();
        include $view;

        return ob_get_clean();
    }

    private function init(): void
    {
        $this->router = new Router();
        $this->request = new Request();
        $this->initPdo();
    }

    private function initPdo()
    {
        $db = getenv('DB');
        $dbHost = getenv('DB_HOST');
        $dbName = getenv('DB_NAME');
        $dbUser = getenv('DB_USER');
        $dbPass = getenv('DB_PASSWORD');

        $dsn = "$db:dbname=$dbName;host=$dbHost";

        $this->pdo = new PDO($dsn, $dbUser, $dbPass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
