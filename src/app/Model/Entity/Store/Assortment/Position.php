<?php

namespace App\Model\Entity\Store\Assortment;

use App\Model\Exceptions\PositionException;

class Position
{
    private Product $product;
    private int $quantity;
    private int $price;

    public function __construct(Product $product, int $price, int $quantity)
    {
        if ($price <= 0) {
            throw new PositionException('Price must be greater than 0');
        }
        if ($quantity < 0) {
            throw new PositionException('Must be greater than 0 or equal');
        }
        $this->price = $price;

        $this->quantity = $quantity;
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
