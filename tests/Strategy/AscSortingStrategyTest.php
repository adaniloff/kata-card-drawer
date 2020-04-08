<?php

namespace App\Tests\Strategy;

use App\Factory\Color\ColorFactoryInterface;
use App\Strategy\FaceAscSortingStrategy;
use App\ValueObject\Card;
use App\ValueObject\CardSet;
use App\ValueObject\Color;
use App\ValueObject\Face;
use PHPUnit\Framework\TestCase;

final class AscSortingStrategyTest extends TestCase
{
    /**
     * @dataProvider getSets
     */
    public function testApply($cardSet, $expectedResultSet): void
    {
        $strategy = new FaceAscSortingStrategy();
        $this->assertEquals($expectedResultSet, $strategy->apply($cardSet));
    }

    public function getSets(): array
    {
        return [
            [
                new CardSet([]),
                new CardSet([]),
            ],
            [
                new CardSet([
                    new Card(new Face(3), new Color(ColorFactoryInterface::COLOR_CHOICE_HEARTS)),
                    new Card(new Face('ace'), new Color(ColorFactoryInterface::COLOR_CHOICE_CLOVERS)),
                    new Card(new Face(7), new Color(ColorFactoryInterface::COLOR_CHOICE_SPADES)),
                    new Card(new Face('jack'), new Color(ColorFactoryInterface::COLOR_CHOICE_HEARTS)),
                    new Card(new Face(4), new Color(ColorFactoryInterface::COLOR_CHOICE_HEARTS)),
                ]),
                new CardSet([
                    new Card(new Face(3), new Color(ColorFactoryInterface::COLOR_CHOICE_HEARTS)),
                    new Card(new Face(4), new Color(ColorFactoryInterface::COLOR_CHOICE_HEARTS)),
                    new Card(new Face(7), new Color(ColorFactoryInterface::COLOR_CHOICE_SPADES)),
                    new Card(new Face('jack'), new Color(ColorFactoryInterface::COLOR_CHOICE_HEARTS)),
                    new Card(new Face('ace'), new Color(ColorFactoryInterface::COLOR_CHOICE_CLOVERS)),
                ])
            ],
        ];
    }
}
