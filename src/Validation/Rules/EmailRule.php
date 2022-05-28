<?php

namespace Core\Validation\Rules;

class EmailRule implements IRule
{
    public function validate($value): bool
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    public function getErrorMessage(): string
    {
        return 'Value must be correct email.';
    }
}
