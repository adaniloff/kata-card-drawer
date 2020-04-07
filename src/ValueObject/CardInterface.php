<?php

namespace App\ValueObject;

use App\Factory\ImplementationInterface;

interface CardInterface extends ImplementationInterface
{
    public function __toString(): string;
    public function getFace(): FaceInterface;
    public function getColor(): ColorInterface;
}
