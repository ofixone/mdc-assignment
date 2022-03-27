<?php

namespace App\Model\Entity\Bill;

use App\Model\Entity\Store\Assortment\Position as StorePosition;

class PurchasePosition
{
    private StorePosition $storePosition;
    private int $quantity;
    private ?string $serialNumber;

    public function __construct(
        StorePosition $storePosition, int $quantity,
        ?string $serialNumber = null
    )
    {
        $this->storePosition = $storePosition;
        $this->quantity = $quantity;
        $this->serialNumber = $serialNumber;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getStorePosition(): StorePosition
    {
        return $this->storePosition;
    }

    public function toPosition(): Position
    {
        return new Position(
            $this->storePosition->getProduct(),
            $this->storePosition->getPrice(),
            $this->quantity,
            $this->serialNumber
        );
    }
}
