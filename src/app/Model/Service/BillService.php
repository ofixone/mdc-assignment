<?php

namespace App\Model\Service;

use App\Model\Contract\Repository\BillRepository;
use App\Model\Contract\Store;
use App\Model\Contract\Validation\Validator;
use App\Model\Entity\Bill\Bill;
use App\Model\Entity\Bill\Customer;
use App\Model\Entity\Bill\Position;
use App\Model\Entity\Bill\PurchasePosition;
use App\Model\Exceptions\ValidationViolation;
use App\Model\Validation\Rule\QuantityRequirement;
use App\Model\Validation\Rule\SerialNumberRequirement;
use DateTimeInterface;

class BillService
{
    private Validator $validator;
    private BillRepository $billRepository;

    public function __construct(
        Validator $validator, BillRepository $billRepository
    )
    {
        $this->validator = $validator;
        $this->billRepository = $billRepository;
    }

    /**
     * @param Store $store
     * @param DateTimeInterface $date
     * @param Customer $customer
     * @param PurchasePosition[] $purchasePositions
     *
     * @return Bill
     *
     * @throws ValidationViolation
     */
    public function purchase(
        Store $store, DateTimeInterface $date, Customer $customer,
        array $purchasePositions
    ): Bill
    {
        $bill = new Bill(
            $this->getNewIdForBill($store, $date),
            $date,
            $customer
        );
        $bill->setPositions(
            $this->getPositionsForBill($store, $purchasePositions)
        );

        $errors = $this->validator->validate(
            [new SerialNumberRequirement($bill)]
        );
        if (count($errors) > 0) {
            throw new ValidationViolation($bill, $errors);
        }

        $this->decreaseQuantity($store, $purchasePositions);

        $store->addBill($bill);

        return $bill;
    }

    private function getNewIdForBill(Store $store, DateTimeInterface $date): int
    {
        $lastYearBill = $this->billRepository->getLastBillByStoreAndYear(
            $store,
            $date->format('Y')
        );
        if (!$lastYearBill) {
            $id = 1;
        } else {
            //TODO: Locker bill transaction must be implemented in the future
            $id = $lastYearBill->getId() + 1;
        }

        return $id;
    }

    /**
     * @param Store $store
     * @param PurchasePosition[] $purchasePositions
     * @return Position[]
     *
     * @throws ValidationViolation
     */
    private function getPositionsForBill(Store $store, array $purchasePositions
    ): array
    {
        $positions = [];
        foreach ($purchasePositions as $purchasePosition) {
            $errors = $this->validator->validate(
                [new QuantityRequirement($purchasePosition, $store)]
            );
            if (count($errors) > 0) {
                throw new ValidationViolation($purchasePosition, $errors);
            }

            $positions[] = $purchasePosition->toPosition();
        }

        return $positions;
    }

    /**
     * @param Store $store
     * @param PurchasePosition[] $purchasePositions
     */
    private function decreaseQuantity(Store $store, array $purchasePositions
    ): void
    {
        foreach ($purchasePositions as $purchasePosition) {
            $currentQuantity = $purchasePosition->getStorePosition()
                ->getQuantity();
            $decreasedQuantity = $purchasePosition->getQuantity();
            $purchasePosition->getStorePosition()->setQuantity(
                $currentQuantity - $decreasedQuantity
            );
        }
    }
}
