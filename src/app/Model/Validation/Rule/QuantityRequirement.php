<?php

namespace App\Model\Validation\Rule;

use App\Model\Contract\Store;
use App\Model\Contract\Validation\Rule;
use App\Model\Entity\Bill\PurchasePosition;

class QuantityRequirement implements Rule
{
    private PurchasePosition $purchasePosition;
    private Store $store;

    public function __construct(PurchasePosition $purchasePosition, Store $store
    )
    {
        $this->purchasePosition = $purchasePosition;
        $this->store = $store;
    }

    public function validate(): array
    {
        $errors = [];

        $productName = $this->purchasePosition->getStorePosition()
            ->getProduct()
            ->getName();
        $storeName = $this->store->getName();

        $foundedPosition = null;

        foreach ($this->store->getAssortment() as $position) {
            if ($this->purchasePosition->getStorePosition() === $position) {
                $foundedPosition = $position;
                break;
            }
        }

        if (!$foundedPosition) {
            $errors[]
                = "Position of product \"$productName\" is not represented in store \"$storeName\"";

            return $errors;
        }

        if ($foundedPosition->getQuantity() === 0) {
            $errors[] = "Not remained \"$productName\"";

            return $errors;
        }

        if (
            $foundedPosition->getQuantity() <
            $this->purchasePosition->getQuantity()
        ) {
            $errors[]
                = "Not enough \"$productName\" in store \"$storeName\": " .
                " need {$this->purchasePosition->getQuantity()}, remain {$foundedPosition->getQuantity()}";
        }

        return $errors;
    }
}
