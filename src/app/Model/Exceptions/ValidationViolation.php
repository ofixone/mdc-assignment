<?php

namespace App\Model\Exceptions;

use DomainException;

class ValidationViolation extends DomainException
{
    /* @var array<string> */
    public array $errors = [];

    public object $owner;

    public function __construct(
        object $owner, array $errors
    )
    {
        $this->owner = $owner;
        $this->errors = $errors;
        parent::__construct('Validate violations');
    }
}
