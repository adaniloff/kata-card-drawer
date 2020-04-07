<?php

namespace App\Tests\Factory\Card;

use App\Factory\Color\ColorFactory;
use App\Factory\ImplementationInterface;
use App\ValueObject\ColorInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ColorFactoryTest extends TestCase
{
    /**
     * @dataProvider invalidArgumentsSet
     */
    public function testCreateByThrowsOnInvalidArguments($arguments, $exceptionType, $exceptionMessage): void
    {
        $factory = new ColorFactory(
            $this->createMock(ValidatorInterface::class)
        );

        $this->expectException($exceptionType);
        $this->expectExceptionMessage($exceptionMessage);

        $factory->createBy($arguments);
    }

    /**
     * @internal
     */
    public function invalidArgumentsSet(): iterable
    {
        return [
            [[], \InvalidArgumentException::class, 'missing color value'],
        ];
    }

    /**
     * @dataProvider invalidValidationsSet
     */
    public function testCreateByThrowsOnInvalidValidations($arguments, $exceptionType, $exceptionMessage): void
    {
        $violation = $this->createMock(ConstraintViolation::class);
        $violation
            ->expects($this->once())
            ->method('getMessage')
            ->willReturn($exceptionMessage);
        $violations = new ConstraintViolationList([$violation]);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator
            ->expects($this->once())
            ->method('validate')
            ->willReturn($violations);

        $factory = new ColorFactory($validator);

        $this->expectException($exceptionType);
        $this->expectExceptionMessage($exceptionMessage);

        $factory->createBy($arguments);
    }

    /**
     * @internal
     */
    public function invalidValidationsSet(): iterable
    {
        return [
            [['color' => 'random'], \LogicException::class, 'invalid instance created'],
        ];
    }

    public function testCreateBySucceed(): void
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator
            ->expects($this->exactly(2))
            ->method('validate')
            ->willReturn([]);

        $color = 'red';

        $factory = new ColorFactory($validator);
        $card = $factory->createBy(['color' => $color]);

        $this->assertInstanceOf(ColorInterface::class, $card);
        $this->assertInstanceOf(ImplementationInterface::class, $card);

        $this->assertEquals($factory->create($color), $card);
    }
}
