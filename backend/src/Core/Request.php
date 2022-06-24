<?php

namespace It20Academy\App\Core;

class Request
{
    private string $controller = 'Index';

    private string $method = 'index';

    public Validator $validator;

    public function __construct()
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $uri = array_diff($uri, []);

        if (isset($uri[1]) && !empty($uri[1])) {
            $this->controller = ucfirst($uri[1]);
        }

        if (isset($uri[2])) {
            $this->method = $uri[2];
        }

        $this->validator = new Validator();
    }

    public function validate($rules): void
    {
        foreach ($rules as $key => $rule) {
            $this->validator->validate($rule, $key, $this->input($key));
        }
    }

    public function getErrors() {
        return $this->validator->errors;
    }

    public function isErrorsNotEmpty() {
        return !!count($this->getErrors());
    }

    public function validateCommand(): bool
    {
        if (!class_exists($this->getController())) {
            dump($this->getController() . " does not exists!");

            return false;
        }

        if (!method_exists($this->getController(), $this->getMethod())) {
            dump("Method {$this->getMethod()} does not exists!");

            return false;
        }

        return true;
    }

    public function getController(): string
    {
        return "It20Academy\App\Controllers\\{$this->controller}Controller";
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function required($value): bool
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

    public function only($keys) {
        $data = [];

        foreach ($keys as $value) {
            $data[$value] = $this->input($value);
        }

        return $data;
    }

    public function input($key) {
        return $_POST[$key] ?? null;
    }

}