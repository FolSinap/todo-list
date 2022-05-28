<?php

namespace Core\Models;

use PDO;

abstract class Model
{
    protected array $fields;
    protected int $id;
    protected PDO $conn;

    public function __construct(PDO $pdo)
    {
        $this->conn = $pdo;
    }

    abstract public function tableName(): string;
    abstract public function columns(): array;

    public function id(): int
    {
        return $this->id;
    }

    public function __set(string $name, $value)
    {
        if (in_array($name, $this->columns())) {
            $this->fields[$name] = $value;
        }
    }

    public function __get(string $name)
    {
        return $this->fields[$name] ?? null;
    }

    public function getForPage(int $page, int $itemsPerPage): array
    {
        $lastId = ($page - 1) * $itemsPerPage;
        $statement = $this->conn->prepare('SELECT * FROM `' . $this->tableName()
            . '` WHERE `id` > ' . $lastId
            . ' LIMIT ' . $itemsPerPage . ';');

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, static::class, [$this->conn]);
    }
}
