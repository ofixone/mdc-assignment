<?php

namespace App\Model\Entity\Bill;

class Customer
{
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;

    public function __construct(
        string $firstName, string $lastName, string $phoneNumber
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}
