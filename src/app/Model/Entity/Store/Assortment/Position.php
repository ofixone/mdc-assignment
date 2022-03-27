<?php

namespace App\Model\Entity\Store\Assortment;

class Position
{
    private Product $product;
    private int $quantity;
    private int $price;

    public function __construct(Product $product, int $price, int $quantity)
    {
        $this->price = $price;
        $this->quantity = $quantity;
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

    public function getProduct(): Product
    {
        return $this->product;
    }
}
