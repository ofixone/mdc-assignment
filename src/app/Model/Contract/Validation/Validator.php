<?php

namespace App\Model\Contract\Validation;

interface Validator
{
    /**
     * @param Rule[] $rules
     */
    public function validate(array $rules): array;
}
