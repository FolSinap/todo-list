<?php

namespace Core\Validation;

use Core\Session;
use Core\Validation\Rules\IRule;

class Validator
{
    protected const SESSION_ERRORS_KEY = 'errors';
    protected array $rules;

    /**
     * @param IRule[][] $rules
     */
    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    public static function flashErrors(string $field): array
    {
        $session = Session::start();
        $sessionKey = self::SESSION_ERRORS_KEY . '.' . $field;

        if (!$session->has($sessionKey)) {
            return [];
        }

        $errors = $session->get($sessionKey);
        $session->unset($sessionKey);

        return $errors;
    }

    public function validate(array $data): bool
    {
        $errorMessages = [];

        foreach ($this->rules as $field => $rules) {
            foreach ($rules as $rule) {
                if (!$rule->validate($data[$field] ?? null)) {
                    $errorMessages[$field][] = $rule->getErrorMessage();
                }
            }
        }

        $this->saveToSession($errorMessages);

        return empty($errorMessages);
    }

    protected function saveToSession(array $messages)
    {
        $session = Session::start();

        foreach ($messages as $nestedKey => $message) {
            $session->set(self::SESSION_ERRORS_KEY . '.' . $nestedKey, $message);
        }
    }
}
