<?php

declare(strict_types=1);

namespace BowlingKata\Domain;

use InvalidArgumentException;

class InvalidKnockedDownPinsException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('You cannot knock down more than 10 pins');
    }
}
