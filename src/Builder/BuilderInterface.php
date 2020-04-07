<?php

namespace App\Builder;

interface BuilderInterface
{
    public function build(): self;
    public function serve();
}
