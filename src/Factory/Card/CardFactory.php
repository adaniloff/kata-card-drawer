<?php

namespace App\Factory\Card;

use App\Factory\ImplementationInterface;
use App\ValueObject\Card;
use App\ValueObject\CardInterface;
use App\ValueObject\ColorInterface;
use App\ValueObject\FaceInterface;

class CardFactory implements CardFactoryInterface
{
    public function createBy(array $data): ImplementationInterface
    {
        [$face, $color] = $this->evaluate($data);

        return $this->create($face, $color);
    }

    public function create(FaceInterface $face, ColorInterface $color): CardInterface
    {
        return new Card($face, $color);
    }

    private function evaluate(array $data): array
    {
        if (!isset($data[self::ARGUMENT_FACE]) || !isset($data[self::ARGUMENT_COLOR])) {
            throw new \InvalidArgumentException(self::ERROR_MISSING_DATA);
        }

        return [$data[self::ARGUMENT_FACE], $data[self::ARGUMENT_COLOR]];
    }
}
