<?php

namespace App\Facade;

use App\Builder\CardSet\CardSetBuilder;
use App\Entity\Deck;
use App\ValueObject\CardInterface;
use App\ValueObject\CardSet;
use PHPUnit\Framework\TestCase;

final class CardGameFacadeTest extends TestCase
{
    private $builder;

    protected function setUp()
    {
        $this->builder = $this->createMock(CardSetBuilder::class);
        parent::setUp();
    }

    public function testBuildDeck(): void
    {
        $this->builder
            ->expects($this->once())
            ->method('build')
            ->willReturn($this->builder);

        $this->builder
            ->expects($this->once())
            ->method('serve')
            ->willReturn(array_fill(0, 52, true));

        $facade = new CardGameFacade($this->builder);
        $deck = $facade->buildDeck();
        $this->assertInstanceOf(Deck::class, $deck);
        $this->assertCount(52, $deck);
    }

    /**
     * @dataProvider quantitiesSets
     */
    public function testDraw($quantity, $expectedDrawnQuantity, $expectedDeckQuantity): void
    {
        $this->builder
            ->expects($this->never())
            ->method('build')
            ->willReturn($this->builder);

        $deck = new Deck(new CardSet(array_fill(0, 52, $this->createMock(CardInterface::class))));

        $facade = new CardGameFacade($this->builder);
        $cardSet = $facade->draw($deck, $quantity);

        $this->assertInstanceOf(CardSet::class, $cardSet);
        $this->assertCount($expectedDeckQuantity, $deck);
        $this->assertCount($expectedDrawnQuantity, $cardSet);
    }

    /**
     * @internal
     */
    public function quantitiesSets(): array
    {
        return [
            [0, 0, 52],
            [1, 1, 51],
            [10, 10, 42],
            [100, 52, 0],
        ];
    }

    public function testSort(): void
    {
        $this->markTestIncomplete();
    }
}
