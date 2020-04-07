<?php

namespace App\Tests\Factory\Card;

use App\Factory\Card\CardFactory;
use App\Factory\ImplementationInterface;
use App\ValueObject\CardInterface;
use App\ValueObject\ColorInterface;
use App\ValueObject\FaceInterface;
use PHPUnit\Framework\TestCase;

final class CardFactoryTest extends TestCase
{
    /**
     * @dataProvider invalidArgumentsSet
     */
    public function testCreateByThrowsOnInvalidArguments($arguments, $exceptionType, $exceptionMessage): void
    {
        $factory = new CardFactory();

        $this->expectException($exceptionType);

        if (null !== $exceptionMessage) {
            $this->expectExceptionMessage($exceptionMessage);
        }

        $factory->createBy($arguments);
    }

    /**
     * @internal
     */
    public function invalidArgumentsSet(): iterable
    {
        return [
            [[], \InvalidArgumentException::class, 'missing data'],
            [['color' => 'random'], \InvalidArgumentException::class, 'missing data'],
            [['face' => 'random'], \InvalidArgumentException::class, 'missing data'],
            [['face' => 'random', 'color' => 'random'], \TypeError::class, null],
        ];
    }

    public function testCreateBySucceed(): void
    {
        $face = $this->createMock(FaceInterface::class);
        $color = $this->createMock(ColorInterface::class);

        $factory = new CardFactory();
        $card = $factory->createBy([
            'face' => $face,
            'color' => $color,
        ]);

        $this->assertInstanceOf(CardInterface::class, $card);
        $this->assertInstanceOf(ImplementationInterface::class, $card);

        $this->assertEquals($factory->create($face, $color), $card);
    }
}
