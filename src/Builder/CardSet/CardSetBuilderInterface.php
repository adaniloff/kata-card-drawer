<?php

namespace App\Builder\CardSet;

use App\Builder\BuilderInterface;
use App\ValueObject\CardInterface;

interface CardSetBuilderInterface extends BuilderInterface
{
    public function addCard(CardInterface $card): self;
    public function addFaceColorAsCard(string $face, string $color): self;
}
