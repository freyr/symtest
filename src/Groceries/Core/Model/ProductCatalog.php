<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model;

class ProductCatalog
{
    public function __construct(
        private array $products
    ) {

    }

    public function exist(ProductId $productId): bool
    {
        return array_key_exists((string)$productId->id, $this->products);
    }

}
