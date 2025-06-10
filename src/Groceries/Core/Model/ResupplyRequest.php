<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model;

class ResupplyRequest
{
    public function __construct(ProductId $productId, Quantity $quantity) {}
}
