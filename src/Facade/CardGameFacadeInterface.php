<?php

namespace App\Facade;

use App\Entity\DeckInterface;
use App\ValueObject\CardSetInterface;

interface CardGameFacadeInterface
{
    public function buildDeck(): DeckInterface;
    public function draw(DeckInterface $deck, int $quantity = 1): CardSetInterface;
    public function sort(CardSetInterface $cardSet, string $strategyName): CardSetInterface;
    public function shuffle(CardSetInterface $cardSet): CardSetInterface;
}
