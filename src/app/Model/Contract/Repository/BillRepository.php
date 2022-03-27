<?php

namespace App\Model\Contract\Repository;

use App\Model\Contract\Store;
use App\Model\Entity\Bill\Bill;

interface BillRepository
{
    public function getLastBillByStoreAndYear(Store $store, string $year
    ): ?Bill;
}
