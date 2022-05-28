<?php

namespace Core\Models;

use PDO;

class Task extends Model
{
    public function tableName(): string
    {
        return 'tasks';
    }

    public function columns(): array
    {
        return [
            'username',
            'email',
            'body',
            'is_done',
        ];
    }
}
