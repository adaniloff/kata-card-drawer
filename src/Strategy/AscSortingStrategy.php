<?php

namespace App\Strategy;

use App\ValueObject\CardSetInterface;

class AscSortingStrategy implements AscSortingStrategyInterface
{
    public function apply(CardSetInterface $cardSet): CardSetInterface
    {
        $cards = $cardSet->toArray();

        sort($cards);

        return $cardSet->setCards($cards);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
