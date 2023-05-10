<?php

declare(strict_types=1);

namespace BowlingKata\Domain;

abstract class Frame
{
    /** @var Roll[] $rolls */
    public array $rolls = [];
    public int $knockedDownPins = 0;
    protected int $numRolls = 0;

    public function __construct()
    {
        for ($rollIndex = 0; $rollIndex < $this->numRolls; $rollIndex++) {
            $this->rolls[] = new Roll();
        }
    }

    public function setFallenPins(int $fallenPins): void
    {
        foreach ($this->rolls as $roll) {
            if (null === $roll->knockedDownPins) {
                $roll->setKnockedDownPins($fallenPins);
                $this->knockedDownPins += $fallenPins;
                return;
            }
        }
    }

    public function firstRoll(): Roll
    {
        return $this->rolls[0];
    }

    public function secondRoll(): Roll
    {
        return $this->rolls[1];
    }

    private function hasKnockedDownAllPins(): bool
    {
        return $this->knockedDownPins === 10;
    }

    public function isStrike(): bool
    {
        return $this->firstRoll()->hasKnockedDownAllPins();
    }

    public function isSpare(): bool
    {
        return $this->hasKnockedDownAllPins() && !$this->isStrike();
    }

    abstract public function hasNextRoll(): bool;
}
