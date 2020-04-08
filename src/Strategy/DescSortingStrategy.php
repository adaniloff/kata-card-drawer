<?php

namespace App\Strategy;

use App\ValueObject\CardSetInterface;

class DescSortingStrategy implements DescSortingStrategyInterface
{
    public function apply(CardSetInterface $cardSet): CardSetInterface
    {
        $cards = $cardSet->toArray();

        rsort($cards);

        return $cardSet->setCards($cards);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
