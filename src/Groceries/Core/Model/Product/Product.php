<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Product;

use App\Groceries\Core\Model\Resupply\Unit;

readonly class Product
{
    public function __construct(
        public ProductId $id,
        public string $name,
        public Unit $unit,
        public CategoryId $categoryId,
    ) {}
}
