<?php

declare(strict_types=1);

namespace BowlingKata\Domain;

class MiddleFrame extends Frame
{
    public function __construct()
    {
        $this->numRolls = 2;
        parent::__construct();
    }

    public function hasNextRoll(): bool
    {
        foreach ($this->rolls as $roll) {
            if (null === $roll->knockedDownPins) {
                return true;
            }
        }

        return false;
    }
}
