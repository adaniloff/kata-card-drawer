<?php

namespace App\ValueObject;

use App\Factory\ImplementationInterface;

interface FaceInterface extends ImplementationInterface
{
    public function __toString(): string;
    public function getName(): string;
}
