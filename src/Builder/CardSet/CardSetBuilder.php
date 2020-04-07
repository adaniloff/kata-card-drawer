<?php

namespace App\Builder\CardSet;

use App\Builder\BuilderInterface;
use App\Factory\Card\CardFactoryInterface;
use App\Factory\Color\ColorFactoryInterface;
use App\Factory\Face\FaceFactoryInterface;
use App\ValueObject\CardInterface;

class CardSetBuilder implements CardSetBuilderInterface
{
    private $data;
    private $cards;

    private $cardFactory;
    private $faceFactory;
    private $colorFactory;

    public function __construct(
        CardFactoryInterface $cardFactory,
        FaceFactoryInterface $faceFactory,
        ColorFactoryInterface $colorFactory
    ) {
        $this->cardFactory = $cardFactory;
        $this->faceFactory = $faceFactory;
        $this->colorFactory = $colorFactory;

        $this->data = $this->cards = [];
    }

    public function addCard(CardInterface $card): CardSetBuilderInterface
    {
        $this->data[] = $card;

        return $this;
    }

    public function addFaceColorAsCard(string $face, string $color): CardSetBuilderInterface
    {
        $this->data[] = [$face, $color];

        return $this;
    }

    public function build(): BuilderInterface
    {
        foreach ($this->data as $card) {
            switch (true) {
                case $card instanceof CardInterface:
                    break;
                default:
                    [$face, $color] = $card;
                    $card = $this->cardFactory->create(
                        $this->faceFactory->create($face),
                        $this->colorFactory->create($color)
                    );
            }
            $this->cards[] = $card;
        }

        return $this;
    }

    public function serve(): iterable
    {
        return $this->cards;
    }
}
