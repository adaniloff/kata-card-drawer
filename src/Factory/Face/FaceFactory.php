<?php

namespace App\Factory\Face;

use App\Factory\ImplementationInterface;
use App\ValueObject\Face;
use App\ValueObject\FaceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FaceFactory implements FaceFactoryInterface
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function createBy(array $data): ImplementationInterface
    {
        if (!isset($data[self::ARGUMENT_FACE])) {
            throw new \InvalidArgumentException(self::ERROR_MISSING_FACE);
        }

        return $this->create($data[self::ARGUMENT_FACE]);
    }

    public function create(string $face): FaceInterface
    {
        $instance = new Face($face);

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
