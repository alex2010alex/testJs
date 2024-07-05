<?php

namespace Aliaksei\Test\Seo;

class Seo
{
    private array $data = [];

    public function add(string $name, string $value): self
    {
        $this->data[$name] = $value;

        return $this;
    }

    public function get(string $name): ?string
    {
        return $this->data[$name];
    }
}