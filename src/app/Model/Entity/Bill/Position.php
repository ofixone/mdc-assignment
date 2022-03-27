<?php

namespace App\Model\Entity\Bill;

use App\Model\Entity\Store\Assortment\Product;

class Position
{
    private int $quantity;
    private int $price;
    //TODO: Any of pack must have own serial number or common?
    private ?string $serialNumber;
    private Product $product;

    public function __construct(
        Product $product, int $price, int $quantity,
        ?string $serialNumber = null
    )
    {
        $this->price = $price;
        $this->quantity = $quantity;
        $this->serialNumber = $serialNumber;
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
