<?php

namespace App\Model\Entity\Store;

use App\Model\Contract\Store;
use App\Model\Entity\Bill\Bill;
use App\Model\Entity\Store\Assortment\Position;
use App\Model\Exceptions\NonUniquePosition;

abstract class AbstractStore implements Store
{
    private string $name;

    /* @var Position[] */
    private array $positions = [];

    /* @var Bill[] */
    private array $bills = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAssortment(): array
    {
        return $this->positions;
    }

    /* @param Position[] $positions */
    public function setAssortment(array $positions): void
    {
        foreach ($positions as $position) {
            $this->addPosition($position);
        }
    }

    public function addPosition(Position $position): void
    {
        foreach ($this->positions as $storePosition) {
            if (
                $storePosition->getProduct()->getName()
                === $position->getProduct()->getName()
            ) {
                throw new NonUniquePosition(
                    'Store already have position with this name'
                );
            }
        }
        $this->positions[] = $position;
    }

    public function addBill(Bill $bill): void
    {
        $this->bills[] = $bill;
    }

    public function getBills(): array
    {
        return $this->bills;
    }

    public function getPositionByName(string $name): ?Position
    {
        foreach ($this->positions as $position) {
            if ($position->getProduct()->getName() === $name) {
                return $position;
            }
        }

        return null;
    }
}
