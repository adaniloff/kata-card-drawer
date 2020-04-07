<?php

namespace App\Factory\Color;

use App\Factory\FactoryInterface;
use App\ValueObject\ColorInterface;

interface ColorFactoryInterface extends FactoryInterface
{
    const ARGUMENT_COLOR = 'color';
    const ERROR_MISSING_COLOR = 'missing color value';
    const COLOR_CHOICE_HEARTS = 'hearts';
    const COLOR_CHOICE_SPADES = 'spades';
    const COLOR_CHOICE_TILES = 'tiles';
    const COLOR_CHOICE_CLOVERS = 'clovers';
    const CHOICES = [
        self::COLOR_CHOICE_HEARTS,
        self::COLOR_CHOICE_SPADES,
        self::COLOR_CHOICE_TILES,
        self::COLOR_CHOICE_CLOVERS,
    ];

    public function create(string $color): ColorInterface;

    public static function getChoices(): array;
}
