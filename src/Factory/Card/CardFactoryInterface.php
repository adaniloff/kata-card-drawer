<?php

namespace App\Factory\Card;

use App\Factory\FactoryInterface;
use App\ValueObject\CardInterface;
use App\ValueObject\ColorInterface;
use App\ValueObject\FaceInterface;

interface CardFactoryInterface extends FactoryInterface
{
    const ARGUMENT_FACE = 'face';
    const ARGUMENT_COLOR = 'color';
    const ERROR_MISSING_DATA = 'missing data';
    const ERROR_INVALID_DATA_SET = 'invalid data set';

    public function create(FaceInterface $face, ColorInterface $color): CardInterface;
}
