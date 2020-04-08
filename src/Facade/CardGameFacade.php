<?php

namespace App\Facade;

use App\Builder\CardSet\CardSetBuilderInterface;
use App\Entity\Deck;
use App\Entity\DeckInterface;
use App\Factory\Color\ColorFactory;
use App\Factory\Face\FaceFactory;
use App\ValueObject\CardSet;
use App\ValueObject\CardSetInterface;

class CardGameFacade implements CardGameFacadeInterface
{
    private $builder;

    public function __construct(CardSetBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function buildDeck(): DeckInterface
    {
        foreach (ColorFactory::getChoices() as $color) {
            foreach (FaceFactory::getChoices() as $face) {
                $this->builder->addFaceColorAsCard($face, $color);
            }
        }

        $cardSet = new CardSet(
            $this->builder
                ->build()
                ->serve()
        );
        $deck = new Deck($this->shuffle($cardSet));

        return $deck;
    }

    public function draw(DeckInterface $deck, int $quantity = 1): CardSetInterface
    {
        $cards = [];

        $deck->rewind();
        while ($deck->current() && 0 < $quantity--) {
            $cards[$deck->key()] = $deck->current();
            $deck->next();
        }

        foreach ($cards as $index => $card) {
            $deck->offsetUnset($index);
        }

        return new CardSet($cards);
    }

    public function sort(CardSetInterface $cardSet): CardSetInterface
    {
        return $cardSet;
    }

    public function shuffle(CardSetInterface $cardSet): CardSetInterface
    {
        $cards = $cardSet->toArray();

        shuffle($cards);

        return $cardSet->setCards($cards);
    }
}
