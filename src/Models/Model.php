<?php

namespace Core\Models;

use Core\App;
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

    public static function new(array $data = []): self
    {
        $model = new static(App::app()->pdo());

        foreach ($data as $field => $value) {
            $model->$field = $value;
        }

        return $model;
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

    public function insert(): void
    {
        $prepared = [];
        $data = [];

        foreach ($this->fields as $field => $value) {
            $prepared["`$field`"] = ":$field";
            $data[$field] = $value;
        }

        $columns = '(' . implode(' ,', array_keys($prepared)) . ')';
        $values = '(' . implode(' ,', array_values($prepared)) . ')';

        $statement = $this->conn->prepare(
            'INSERT INTO ' . $this->tableName() . ' ' . $columns . ' VALUES ' . $values . ';'
        );

        foreach ($this->fields as $field => $value) {
            $statement->bindValue(":$field", $value, $this->getType($value));
        }

        $statement->execute();
    }

    public function getForPage(int $page, int $itemsPerPage, bool &$nextPageExists): array
    {
        $lastId = ($page - 1) * $itemsPerPage;
        $statement = $this->conn->prepare('SELECT * FROM `' . $this->tableName()
            . '` WHERE `id` > ' . $lastId
            . ' LIMIT ' . ($itemsPerPage + 1) . ';');

        $statement->execute();
        $items = $statement->fetchAll(PDO::FETCH_CLASS, static::class, [$this->conn]);

        if (count($items) > $itemsPerPage) {
            $nextPageExists = true;
            array_pop($items);
        } else {
            $nextPageExists = false;
        }

        return $items;
    }

    private function getType($value): int
    {
        switch (true) {
            case is_int($value):
                return PDO::PARAM_INT;
            case is_bool($value):
                return PDO::PARAM_BOOL;
            case is_null($value):
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }
}
