<?php

namespace Core\Models;

use Core\App;
use PDO;

abstract class Model
{
    protected array $fields;
    protected int $id;

    public static function new(array $data = []): self
    {
        $model = new static();

        foreach ($data as $field => $value) {
            $model->$field = $value;
        }

        return $model;
    }

    abstract public static function tableName(): string;
    abstract public static function columns(): array;

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

    public static function find(int $id): ?self
    {
        $models = self::where('id', $id);

        if (empty($models)) {
            return null;
        }

        return $models[0];
    }

    public static function where(string $field, $value, string $operand = '='): array
    {
        $statement = App::app()->pdo()->prepare(
            'SELECT * FROM ' . static::tableName() . " WHERE $field $operand :$field;"
        );
        $statement->bindValue(":$field", $value, self::getType($value));
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public function update(array $data): void
    {
        $prepared = '';

        foreach ($data as $field => $value) {
            $prepared .= " `$field` = :$field,";
        }

        $prepared = rtrim($prepared, ',');

        $statement = App::app()->pdo()->prepare(
            'UPDATE ' . $this->tableName() . ' SET ' . $prepared . ' WHERE `id` = ' . $this->id() . ';'
        );

        foreach ($data as $field => $value) {
            $statement->bindValue(":$field", $value, self::getType($value));
        }

        $statement->execute();
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

        $statement = App::app()->pdo()->prepare(
            'INSERT INTO ' . $this->tableName() . ' ' . $columns . ' VALUES ' . $values . ';'
        );

        foreach ($this->fields as $field => $value) {
            $statement->bindValue(":$field", $value, self::getType($value));
        }

        $statement->execute();
    }

    public static function getForPage(int $page, int $itemsPerPage, bool &$nextPageExists, string $orderBy = 'id', string $orderDirection = 'ASC'): array
    {
        $offset = ($page - 1) * $itemsPerPage;
        $statement = App::app()->pdo()->prepare('SELECT * FROM `' . static::tableName() . '`'
            . ' ORDER BY `' . $orderBy . '` ' . $orderDirection
            . ' LIMIT ' . ($itemsPerPage + 1)
            . ' OFFSET ' . $offset . ';'
        );

        $statement->execute();
        $items = $statement->fetchAll(PDO::FETCH_CLASS, static::class);

        if (count($items) > $itemsPerPage) {
            $nextPageExists = true;
            array_pop($items);
        } else {
            $nextPageExists = false;
        }

        return $items;
    }

    private static function getType($value): int
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
