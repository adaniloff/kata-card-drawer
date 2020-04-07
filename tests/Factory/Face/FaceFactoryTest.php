<?php

namespace App\Tests\Factory\Card;

use App\Factory\Face\FaceFactory;
use App\Factory\ImplementationInterface;
use App\ValueObject\FaceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class FaceFactoryTest extends TestCase
{
    /**
     * @dataProvider invalidArgumentsSet
     */
    public function testCreateByThrowsOnInvalidArguments($arguments, $exceptionType, $exceptionMessage): void
    {
        $factory = new FaceFactory(
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
            [[], \InvalidArgumentException::class, 'missing face value'],
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

        $factory = new FaceFactory($validator);

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
            [['face' => 'random'], \LogicException::class, 'invalid instance created'],
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

        $factory = new FaceFactory($validator);
        $card = $factory->createBy(['face' => $color]);

        $this->assertInstanceOf(FaceInterface::class, $card);
        $this->assertInstanceOf(ImplementationInterface::class, $card);

        $this->assertEquals($factory->create($color), $card);
    }
}
