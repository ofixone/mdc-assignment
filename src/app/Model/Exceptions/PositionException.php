<?php

namespace App\Model\Exceptions;

use DomainException;

class PositionException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
