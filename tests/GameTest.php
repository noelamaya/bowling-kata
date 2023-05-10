<?php

declare(strict_types=1);

namespace Tests;

use BowlingKata\Application\Game;
use BowlingKata\Domain\InvalidKnockedDownPinsException;
use BowlingKata\Domain\RollOutOfGameException;
use Generator;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testKnockMoreThanTenPins(): void
    {
        $game = new Game();

        $this->expectException(InvalidKnockedDownPinsException::class);
        $this->expectExceptionMessage('You cannot knock down more than 10 pins');

        $game->roll(11);
    }
    /** @dataProvider provideCorrectRolls */
    public function testBowling(int $expectedScore, array $rolls): void
    {
        $game = new Game();

        foreach ($rolls as $pinsKnockedDown) {
            $game->roll($pinsKnockedDown);
        }

        static::assertSame($expectedScore, $game->score());
    }


    /** @dataProvider provideOutOfGameRolls */
    public function testRollMoreThanTheScope(array $rolls): void
    {
        $game = new Game();

        $this->expectException(RollOutOfGameException::class);

        foreach ($rolls as $roll) {
            $game->roll($roll);
        }

        $game->score();
    }

    public static function provideCorrectRolls(): Generator
    {
        yield 'first single roll without strike' => [
            5,
            [5,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0],
        ];
        yield 'first frame without spare' => [
            7,
            [5,2, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0],
        ];
        yield 'spare in first frame' => [
            25,
            [5,5, 5,3, 2,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0], //15+8+2
        ];
        yield 'strike in first roll' => [
            28,
            [10, 5,3, 2,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0], //18+8+2
        ];
        yield 'double in two first rolls' => [
            53,
            [10, 10, 5,3, 2,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0], //25+18+8+2
        ];
        yield 'triple in three first rolls' => [
            83,
            [10, 10, 10, 5,3, 2,0, 0,0, 0,0, 0,0, 0,0, 0,0], //30+25+18+8+2
        ];
        yield 'last frame with spare' => [
            15,
            [0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 7,3,5], //7+3+5
        ];
        yield 'last frame with spare and strike' => [
            20,
            [0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 7,3,10], //7+3+10
        ];
        yield 'last frame with strike and spare' => [
            20,
            [0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 10,7,3], //10+7+3
        ];
        yield 'last frame with one strike' => [
            18,
            [0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 10,3,5], //10+3+5
        ];
        yield 'last frame with two strikes' => [
            25,
            [0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 10,10,5], //10+10+5
        ];
        yield 'last frame with three strikes' => [
            30,
            [0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 10,10,10], //10+10+10
        ];
    }

    public static function provideOutOfGameRolls(): Generator
    {
        yield 'more than 10 frames' => [
            [3,2, 0,0, 10, 2,7, 3,7, 5,5, 0,0, 1,0, 0,1, 7,3,5, 3,4],
        ];
        yield 'wrong third roll on last frame' => [
            [0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,3,5],
        ];
    }
}
