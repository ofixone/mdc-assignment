<?php

namespace App\Model\Validation;

use App\Model\Contract\Validation\Validator as Contract;

class Validator implements Contract
{
    /* @inheritDoc */
    public function validate(array $rules): array
    {
        $errors = [];
        foreach ($rules as $rule) {
            $errors = [...$errors, ...$rule->validate()];
        }

        return $errors;
    }
}
