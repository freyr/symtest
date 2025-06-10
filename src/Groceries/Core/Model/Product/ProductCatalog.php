<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Product;

class ProductCatalog
{

    /** @var array<string, Product> */
    private array $products;
    public function __construct(
        /** @var array<string, Product> $products */
        array $products
    )
    {
        foreach ($products as $product) {
            $this->products[(string)$product->id->id] = $product;
        }
    }

    public function exist(ProductId $productId): bool
    {
        return array_key_exists((string)$productId->id, $this->products);
    }

    public function getCategoryId(ProductId $productId): ?CategoryId
    {
        if ($this->exist($productId)) {
            $product = $this->products[(string)$productId->id];
            return $product->categoryId;
        }

        return null;
    }


}
