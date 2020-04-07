<?php

namespace App\Factory\Color;

use App\Factory\ImplementationInterface;
use App\ValueObject\Color;
use App\ValueObject\ColorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ColorFactory implements ColorFactoryInterface
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function createBy(array $data): ImplementationInterface
    {
        if (!isset($data[self::ARGUMENT_COLOR])) {
            throw new \InvalidArgumentException(self::ERROR_MISSING_COLOR);
        }

        return $this->create($data[self::ARGUMENT_COLOR]);
    }

    public function create(string $color): ColorInterface
    {
        $instance = new Color($color);

        if ($errors = $this->validator->validate($instance)) {
            if (count($errors)) {
                throw new \LogicException($errors->get(0)->getMessage());
            }
        }

        return $instance;
    }

    public static function getChoices(): array
    {
        return self::CHOICES;
    }
}
