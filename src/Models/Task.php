<?php

namespace Core\Models;

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
