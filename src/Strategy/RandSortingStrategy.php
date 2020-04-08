<?php

namespace App\Strategy;

use App\ValueObject\CardSetInterface;

class RandSortingStrategy implements RandSortingStrategyInterface
{
    public function apply(CardSetInterface $cardSet): CardSetInterface
    {
        $cards = $cardSet->toArray();

        shuffle($cards);

        return $cardSet->setCards($cards);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
