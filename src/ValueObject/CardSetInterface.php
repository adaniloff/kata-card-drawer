<?php

namespace App\ValueObject;

interface CardSetInterface extends \ArrayAccess, \Iterator, \Countable
{
    public function toArray(): array;
    public function setCards(array $cards): self;
}
