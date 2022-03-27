<?php

namespace App\Model\Contract\Validation;

interface Rule
{
    public function validate(): array;
}
