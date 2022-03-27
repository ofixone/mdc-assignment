<?php

namespace App\Model\Entity\Bill;

use App\Model\Exceptions\NonUniquePosition;
use DateTimeInterface;

class Bill
{
    private int $id;
    private DateTimeInterface $date;
    private Customer $customer;

    /* @var Position[] */
    private array $positions = [];

    public function __construct(
        int $id, DateTimeInterface $date, Customer $customer
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->customer = $customer;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /* @return Position[] $positions */
    public function getPositions(): array
    {
        return $this->positions;
    }

    /* @param Position[] $positions */
    public function setPositions(array $positions): void
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
                    'Bill already have position with this name'
                );
            }
        }
        $this->positions[] = $position;
    }


}
