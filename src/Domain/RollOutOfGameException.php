<?php

declare(strict_types=1);

namespace BowlingKata\Domain;

use DomainException;

class RollOutOfGameException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Roll out of scope. Game was ended');
    }
}
