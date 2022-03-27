<?php

namespace App\Model\Validation\Rule;

use App\Model\Contract\Validation\Rule;
use App\Model\Entity\Bill\Bill;
use App\Model\Entity\Store\Assortment\Product;

class SerialNumberRequirement implements Rule
{
    private Bill $bill;

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    public function validate(): array
    {
        $errors = [];
        foreach ($this->bill->getPositions() as $position) {
            $positionType = $position->getProduct()->getType();
            $positionName = $position->getProduct()->getName();

            if (
                in_array(
                    $position->getProduct()->getType(),
                    [Product::TYPE_PARKING_TICKET, Product::TYPE_MEDICINE]
                ) && !($position->getSerialNumber())
            ) {
                $errors[]
                    = "Position $positionName must have serial number cause type is \"$positionType\"";
            }
        }

        return $errors;
    }
}
