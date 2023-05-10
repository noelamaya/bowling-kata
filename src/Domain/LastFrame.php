<?php

declare(strict_types=1);

namespace BowlingKata\Domain;

class LastFrame extends Frame
{
    public function __construct()
    {
        $this->numRolls = 3;
        parent::__construct();
    }

    public function hasNextRoll(): bool
    {
        if ($this->isThirdRoll() || $this->isSecondRoll() && !$this->isSpare() && !$this->isStrike()) {
            return false;
        }

        return true;
    }

    private function thirdRoll(): Roll
    {
        return $this->rolls[2];
    }

    private function isSecondRoll(): bool
    {
        return !$this->isThirdRoll() && null !== $this->secondRoll()->knockedDownPins;
    }

    private function isThirdRoll(): bool
    {
        return null !== $this->thirdRoll()->knockedDownPins;
    }
}
