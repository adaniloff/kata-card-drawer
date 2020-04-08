<?php

namespace App\Entity;

use App\ValueObject\CardInterface;
use App\ValueObject\CardSet;
use App\ValueObject\CardSetInterface;

class Deck implements DeckInterface
{
    private $cardSet;

    public function __construct(CardSetInterface $cardSet)
    {
        $this->cardSet = $cardSet;
    }

    public function current(): ?CardInterface
    {
        return $this->cardSet->current();
    }

    public function next(): void
    {
        $this->cardSet->next();
    }

    public function key(): ?int
    {
        return $this->cardSet->key();
    }

    public function valid(): bool
    {
        return $this->cardSet->valid();
    }

    public function rewind(): void
    {
    }

    public function offsetExists($offset): bool
    {
        return $this->cardSet->offsetExists($offset);
    }

    public function offsetGet($offset): CardInterface
    {
        return $this->cardSet->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->cardSet->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->cardSet->offsetUnset($offset);
    }

    public function toArray(): array
    {
        return $this->cardSet->toArray();
    }

    public function count(): int
    {
        return $this->cardSet->count();
    }

    public function setCards(array $cards): CardSetInterface
    {
        return $this->cardSet = new CardSet($cards);
    }
}
