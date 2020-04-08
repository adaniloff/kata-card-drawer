<?php

namespace App\Facade;

use App\Builder\CardSet\CardSetBuilderInterface;
use App\Entity\Deck;
use App\Entity\DeckInterface;
use App\Factory\Color\ColorFactory;
use App\Factory\Face\FaceFactory;
use App\Strategy\RandSortingStrategyInterface;
use App\Strategy\SortingStrategyInterface;
use App\ValueObject\CardSet;
use App\ValueObject\CardSetInterface;

class CardGameFacade implements CardGameFacadeInterface
{
    const UNKNOWN_SORTING_STRATEGY = 'Unknown sorting strategy.';

    private $builder;

    /**
     * @var \Traversable|SortingStrategyInterface[]
     */
    private $strategies;

    public function __construct(CardSetBuilderInterface $builder, \Traversable $strategies)
    {
        $this->builder = $builder;
        $this->strategies = $strategies;
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

    public function sort(CardSetInterface $cardSet, string $strategyName): CardSetInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategyName === $strategy->getName()) {
                return $strategy->apply($cardSet);
            }
        }

        throw new \LogicException(self::UNKNOWN_SORTING_STRATEGY);
    }

    public function shuffle(CardSetInterface $cardSet): CardSetInterface
    {
        return $this->sort($cardSet, RandSortingStrategyInterface::NAME);
    }
}
