<?php

namespace Core\Validation\Rules;

class NotEmptyRule implements IRule
{
    public function validate($value): bool
    {
        if (empty($value)) {
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return 'Value must not be empty.';
    }
}