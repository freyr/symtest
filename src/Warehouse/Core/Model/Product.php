<?php

declare(strict_types=1);

namespace App\Warehouse\Core\Model;

class Product {

    private Quantity $quantity;
    public function __construct(
        private ProductId $productId,
        private SupplierId $supplierId,
        private Unit $unit
    ) {
        $this->quantity = new Quantity(0, $unit);
    }

    public function addQuantity(Quantity $quantity): void
    {
        $this->quantity->add($quantity);
    }

    public function removeQuantity(Quantity $quantity): void
    {
        $this->quantity->remove($quantity);
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getSupplierId(): SupplierId
    {
        return $this->supplierId;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }
}
