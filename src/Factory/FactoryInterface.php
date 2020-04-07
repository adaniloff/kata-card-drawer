<?php

namespace App\Factory;

interface FactoryInterface
{
    public function createBy(array $data): ImplementationInterface;
}
