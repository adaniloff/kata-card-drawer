<?php

namespace App\Factory\Face;

use App\Factory\FactoryInterface;
use App\ValueObject\FaceInterface;

interface FaceFactoryInterface extends FactoryInterface
{
    const ARGUMENT_FACE = 'face';
    const ERROR_MISSING_FACE = 'missing face value';
    const CHOICES = [
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        'jack',
        'queen',
        'king',
        'ace',
    ];

    public function create(string $face): FaceInterface;

    public static function getChoices(): array;
}
