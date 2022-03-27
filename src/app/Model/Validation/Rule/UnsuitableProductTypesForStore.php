<?php

namespace App\Model\Validation\Rule;

use App\Model\Contract\Store;
use App\Model\Contract\Validation\Rule;

class UnsuitableProductTypesForStore implements Rule
{
    private Store $store;
    private array $unsuitableTypes;

    public function __construct(Store $store, array $unsuitableTypes = [])
    {
        $this->store = $store;
        $this->unsuitableTypes = $unsuitableTypes;
    }

    public function validate(): array
    {
        $errors = [];
        foreach ($this->store->getAssortment() as $position) {
            $positionType = $position->getProduct()->getType();
            $positionName = $position->getProduct()->getName();
            $storeName = $this->store->getName();

            if (in_array($positionType, $this->unsuitableTypes)) {
                $errors[]
                    = "Unsuitable type \"$positionType\" for product \"$positionName\" in \"$storeName\"";
            }
        }

        return $errors;
    }
}
