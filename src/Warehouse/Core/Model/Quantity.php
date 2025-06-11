<?php

declare(strict_types=1);

namespace App\Warehouse\Core\Model;

class Quantity
{
    public function __construct(
        private float $qty,
        public readonly Unit $unit,
    ) {}

    public function add(Quantity $quantity): void
    {
        if ($quantity->unit !== $this->unit) {
            throw new \InvalidArgumentException('Cannot add quantities with different units');
        }
        $this->qty += $quantity->qty;
    }

    public function remove(Quantity $quantity)
    {
        if ($quantity->unit !== $this->unit) {
            throw new \InvalidArgumentException('Cannot add quantities with different units');
        }
        $this->qty -= $quantity->qty;
    }

    public function getQty(): float
    {
        return $this->qty;
    }

}
