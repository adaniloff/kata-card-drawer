<?php

namespace App\ValueObject;

class Color implements ColorInterface
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
