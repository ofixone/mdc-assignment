<?php

namespace App\Model\Entity\Report;

use App\Model\Entity\Store\Assortment\Product;

//TODO: Would be nice to add serialization to an array, string, or json if required.
class Report
{
    /** @var Row[] */
    private array $rows = [];

    public function addRowOrQuantityIfExist(Product $product, int $quantity
    ): void
    {
        foreach ($this->rows as $row) {
            if ($row->getProduct() === $product) {
                $row->increaseQuantity($quantity);
                return;
            }
        }

        $this->rows[] = new Row($product, $quantity);
    }

    public function getRowByProductName(string $name): ?Row
    {
        foreach ($this->getRows() as $row) {
            if ($row->getProduct()->getName() === $name) {
                return $row;
            }
        }

        return null;
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
