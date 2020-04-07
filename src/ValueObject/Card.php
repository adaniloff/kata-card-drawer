<?php

namespace App\ValueObject;

class Card implements CardInterface
{
    private $face;
    private $color;

    public function __construct(FaceInterface $face, ColorInterface $color)
    {
        $this->face = $face;
        $this->color = $color;
    }

    public function __toString(): string
    {
        return $this->face . ' of ' . $this->color;
    }

    public function getFace(): FaceInterface
    {
        return $this->face;
    }

    public function getColor(): ColorInterface
    {
        return $this->color;
    }
}
