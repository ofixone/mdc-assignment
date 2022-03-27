<?php

namespace App\Model\Entity\Report;

use App\Model\Entity\Store\Assortment\Product;

class Row
{
    private Product $product;
    private int $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function increaseQuantity(int $quantity)
    {
        $this->quantity += $quantity;
    }
}
