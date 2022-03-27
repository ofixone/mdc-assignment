<?php

namespace App\Model\Exceptions;

use DomainException;

class UnpredictableProductType extends DomainException
{
    public function __construct(array $suitableTypes)
    {
        parent::__construct(
            'Incorrect product type, must be in range ' .
            print_r($suitableTypes, true),
        );
    }
}
