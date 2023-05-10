<?php

declare(strict_types=1);

namespace BowlingKata\Domain;

class Roll
{
    public ?int $knockedDownPins = null;

    public function hasKnockedDownAllPins(): bool
    {
        return $this->knockedDownPins === 10;
    }

    public function setKnockedDownPins(int $knockedDownPins): void
    {
        if ($knockedDownPins > 10) {
            throw new InvalidKnockedDownPinsException();
        }
        $this->knockedDownPins = $knockedDownPins;
    }
}
