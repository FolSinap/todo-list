<?php

namespace Core\Validation\Rules;

interface IRule
{
    public function validate($value): bool;

    public function getErrorMessage(): string;
}
