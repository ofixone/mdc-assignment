<?php

namespace App\Model\Contract\Repository;

use App\Model\Contract\Store;
use App\Model\Entity\Bill\Bill;
use DateTimeInterface;

interface BillRepository
{
    public function getLastBillByStoreAndYear(Store $store, string $year
    ): ?Bill;

    //TODO: Pagination would be nice to improve performance, but now for now :)

    /* @return Bill[] */
    public function getAllBillsInPeriodByStore(
        Store $store, DateTimeInterface $begin, DateTimeInterface $end
    ): array;
}
