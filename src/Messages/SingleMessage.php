<?php

namespace Aliaksei\Test\Messages;

class SingleMessage
{
    protected static ?self $Instance = null;

    protected array $message = [];

    public static function GetInstance(): self
    {
        if (!static::$Instance) {
            static::$Instance = new self();
        }

        return static::$Instance;
    }

    public function add(string $message): self
    {
        $this->message[] = $message;

        return $this;
    }

    public function getAll(): array
    {
        return $this->message;
    }
}