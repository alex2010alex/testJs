<?php

namespace Aliaksei\Test;

class Request
{
    private static ?self $Instance = null;

    private array $data;

    private function __construct() {
        $this->data = [
            'GET' => $_GET,
            'POST' => $_POST,
            'COOKIE' => $_COOKIE,
            'REQUEST' => $_REQUEST
        ];
    }

    public static function GetInstance(): self
    {
        if (is_null(static::$Instance)) {
            static::$Instance = new self();
        }

        return static::$Instance;
    }

    public function get(string $name): mixed
    {
        return @htmlentities($this->data['GET'][$name]);
    }

    public function post(string $name): mixed
    {
        return @htmlentities($this->data['POST'][$name]);
    }

    public function cookie(string $name): mixed
    {
        return @htmlentities($this->data['COOKIE'][$name]);
    }

    public function mixed(string $name): mixed
    {
        return @htmlentities($this->data['REQUEST'][$name]);
    }
}