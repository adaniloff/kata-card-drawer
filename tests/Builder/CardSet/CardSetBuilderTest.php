<?php

namespace App\Tests\Builder\CardSet;

use App\Builder\CardSet\CardSetBuilder;
use App\Factory\Card\CardFactoryInterface;
use App\Factory\Color\ColorFactoryInterface;
use App\Factory\Face\FaceFactoryInterface;
use PHPUnit\Framework\TestCase;

final class CardSetBuilderTest extends TestCase
{
    public function testAddRandomCards(): void
    {
        $cardFactory = $this->createMock(CardFactoryInterface::class);
        $faceFactory = $this->createMock(FaceFactoryInterface::class);
        $colorFactory = $this->createMock(ColorFactoryInterface::class);

        $builder = new CardSetBuilder($cardFactory, $faceFactory, $colorFactory);
        $data = new \ReflectionProperty($builder, 'data');
        $data->setAccessible(true);
        $cards = new \ReflectionProperty($builder, 'cards');
        $cards->setAccessible(true);

        $this->assertEquals([], $data->getValue($builder));
        $this->assertEquals([], $cards->getValue($builder));

        for ($i = 0; $i < $count = 5; $i++) {
            $builder->addFaceColorAsCard(FaceFactoryInterface::CHOICES[0], ColorFactoryInterface::CHOICES[0]);
        }

        $this->assertCount($count, $data->getValue($builder));
        $this->assertEquals([], $cards->getValue($builder));

        $builder->build();

        $this->assertCount($count, $cards->getValue($builder));

        $cards = $builder->serve();

        $this->assertIsArray($cards);
        $this->assertCount($count, $cards);
    }
}
