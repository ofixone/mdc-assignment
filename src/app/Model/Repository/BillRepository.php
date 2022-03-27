<?php

namespace App\Model\Repository;

use App\Model\Contract\Store;
use App\Model\Entity\Bill\Bill;
use DateTimeInterface;

class BillRepository implements \App\Model\Contract\Repository\BillRepository
{
    public function getLastBillByStoreAndYear(Store $store, string $year): ?Bill
    {
        /** @var Bill|null $lastBillByYear */
        $lastBillByYear = null;

        foreach ($store->getBills() as $bill) {
            if (
                $bill->getDate()->format('Y') === $year
                && (
                    !$lastBillByYear ||
                    $lastBillByYear->getDate() < $bill->getDate()
                )
            ) {
                $lastBillByYear = $bill;
            }
        }

        return $lastBillByYear;
    }

    /* @inheritDoc */
    public function getAllBillsInPeriodByStore(
        Store $store, DateTimeInterface $begin, DateTimeInterface $end
    ): array
    {
        $suitableBills = [];

        foreach ($store->getBills() as $bill) {
            if ($bill->getDate() >= $begin && $bill->getDate() <= $end) {
                $suitableBills[] = $bill;
            }
        }

        return $suitableBills;
    }
}
