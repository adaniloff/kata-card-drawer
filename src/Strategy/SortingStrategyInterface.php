<?php

namespace App\Strategy;

use App\ValueObject\CardSetInterface;

interface SortingStrategyInterface
{
    public function apply(CardSetInterface $cardSet): CardSetInterface;
    public function getName(): string;
}
