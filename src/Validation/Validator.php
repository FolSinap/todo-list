<?php

namespace Core\Validation;

use Core\Session;
use Core\Validation\Rules\IRule;

class Validator
{
    protected array $rules;

    /**
     * @param IRule[][] $rules
     */
    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
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

    protected function saveToSession(array $messages, string $key = 'errors')
    {
        $session = Session::start();

        foreach ($messages as $nestedKey => $message) {
            $session->set("$key.$nestedKey", $message);
        }
    }
}
