<?php

namespace App\Model\Exceptions;

use DomainException;

class NonUniquePosition extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
