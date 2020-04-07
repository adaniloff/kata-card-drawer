<?php

namespace App\ValueObject;

use App\Factory\ImplementationInterface;

interface ColorInterface extends ImplementationInterface
{
    public function __toString(): string;
    public function getName(): string;
}
