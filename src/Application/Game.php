<?php

declare(strict_types=1);

namespace BowlingKata\Application;

use BowlingKata\Domain\Frame;
use BowlingKata\Domain\LastFrame;
use BowlingKata\Domain\MiddleFrame;
use BowlingKata\Domain\Roll;
use BowlingKata\Domain\RollOutOfGameException;

class Game
{
    private const GAME_FRAMES = 10;
    private array $frames = [];
    private int $frameNumber = 0;

    public function __construct()
    {
        for ($frameIndex = 0; $frameIndex < self::GAME_FRAMES - 1; $frameIndex++) {
            $this->frames[] = new MiddleFrame();
        }
        $this->frames[] = new LastFrame();
    }

    public function roll(int $fallenPins): void
    {
        $this->currentFrame()->setFallenPins($fallenPins);

        if (($fallenPins === 10 && !$this->isLastFrame()) || !$this->currentFrame()->hasNextRoll()) {
            ++$this->frameNumber;
        }
    }

    public function score(): int
    {
        $score = 0;

        try {
            $this->currentFrame();
        } catch (RollOutOfGameException) {
            $this->frameNumber--;
        }

        while ($this->frameNumber >= 0) {
            $frameScore = $this->currentFrame()->knockedDownPins;
            if ($this->currentFrame()->isStrike()) {
                $frameScore += $this->strikeBonus();
            }
            if ($this->currentFrame()->isSpare()) {
                $frameScore += $this->spareBonus();
            }

            $score += $frameScore;
            --$this->frameNumber;
        }

        return $score;
    }

    public function spareBonus(): int
    {
        if ($this->isLastFrame()) {
            return 0;
        }

        return (int)$this->nextFrame()->firstRoll()->knockedDownPins;
    }

    public function strikeBonus(): int
    {
        if ($this->isLastFrame()) {
            return 0;
        }

        $bonus = 0;
        foreach ($this->nextTwoRolls() as $nextRoll) {
            $bonus += (int)$nextRoll->knockedDownPins;
        }

        return $bonus;
    }

    public function currentFrame(): Frame
    {
        if ($this->frameNumber > 9) {
            throw new RollOutOfGameException();
        }

        return $this->frames[$this->frameNumber];
    }

    public function nextFrame(): Frame
    {
        return $this->getFrameAhead(1);
    }

    public function nextSecondFrame(): Frame
    {
        return $this->getFrameAhead(2);
    }

    private function getFrameAhead(int $numFramesAhead): Frame
    {
        if (!isset($this->frames[$this->frameNumber + $numFramesAhead])) {
            throw new RollOutOfGameException();
        }

        return $this->frames[$this->frameNumber + $numFramesAhead];
    }

    /** @return Roll[] */
    public function nextTwoRolls(): array
    {
        $firstRoll = $this->nextFrame()->firstRoll();
        $secondRoll = $this->nextFrame()->firstRoll()->hasKnockedDownAllPins()
            ? $this->nextSecondFrame()->firstRoll()
            : $this->nextFrame()->secondRoll();

        return [$firstRoll, $secondRoll];
    }


    public function isLastFrame(): bool
    {
        return $this->frameNumber === 9;
    }
}
