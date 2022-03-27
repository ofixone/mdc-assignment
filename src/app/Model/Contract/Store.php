<?php

namespace App\Model\Contract;

use App\Model\Entity\Store\Assortment\Position;

interface Store
{
    public function getName(): string;

    public function getType(): string;

    /** @var Position[] */
    public function getAssortment(): array;
}
