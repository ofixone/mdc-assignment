<?php

namespace App\Model\Contract;

use App\Model\Entity\Bill\Bill;
use App\Model\Entity\Store\Assortment\Position;

interface Store
{
    public function getName(): string;

    public function getType(): string;

    /** @return Position[] */
    public function getAssortment(): array;

    public function getPositionByName(string $name): ?Position;

    public function addBill(Bill $bill): void;

    /** @return Bill[] */
    public function getBills(): array;
}
