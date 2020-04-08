<?php

namespace App\Strategy;

use App\Factory\Face\FaceFactoryInterface;
use App\ValueObject\CardSetInterface;

class FaceDescSortingStrategy implements FaceDescSortingStrategyInterface
{
    public function apply(CardSetInterface $cardSet): CardSetInterface
    {
        $cards = $cardSet->toArray();

        usort($cards, function ($cardA, $cardB) {
            return array_keys(FaceFactoryInterface::CHOICES, $cardA->getFace()->getName())[0]
                > array_keys(FaceFactoryInterface::CHOICES, $cardB->getFace()->getName())[0]
                ? -1 : 1;
        });

        return $cardSet->setCards($cards);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
