<?php

namespace App\ValueObject;

class CardSet implements CardSetInterface
{
    private $cards;
    private $current;

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    public function toArray(): array
    {
        return $this->cards;
    }

    public function current(): ?CardInterface
    {
        $this->current = current($this->cards);

        return $this->current ?: null;
    }

    public function next(): void
    {
        $this->current = next($this->cards);
    }

    public function key(): ?int
    {
        $key = key($this->cards);

        return null !== $key ? (int)$key : null;
    }

    public function valid(): bool
    {
        return false !== $this->current;
    }

    public function rewind(): void
    {
        $this->current = reset($this->cards);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->cards[$offset]);
    }

    public function offsetGet($offset): CardInterface
    {
        return $this->cards[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->cards[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->cards[$offset]);
    }

    public function count(): int
    {
        return count($this->cards);
    }
}
