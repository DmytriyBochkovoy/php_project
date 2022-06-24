<?php

namespace It20Academy\App\Core;

class Validator
{
    protected static array $rules = [
        'required',
    ];

    public array $errors = [];

    public array $massages = [
        'required' => 'Field is required'
    ];

    public function validate (array $rules, $name, $value) {
        foreach ($rules as $rule) {
            if (in_array($rule, self::$rules)) {
                if (!$this->{$rule}($value)) {
                    $this->errors[$name][] = $this->massages[$rule];
                }
            }
        }
    }

    public function required ($value): bool
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        } elseif (is_array($value) && count($value) < 1) {
            return false;
        }

        return true;
    }
}