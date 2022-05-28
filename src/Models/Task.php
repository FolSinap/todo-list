<?php

namespace Core\Models;

class Task extends Model
{
    public static function tableName(): string
    {
        return 'tasks';
    }

    public static function columns(): array
    {
        return [
            'username',
            'email',
            'body',
            'is_done',
        ];
    }
}
