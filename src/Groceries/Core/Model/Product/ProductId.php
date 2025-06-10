<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Product;

use Ramsey\Uuid\UuidInterface;

readonly class ProductId
{
    public function __construct(
        public UUidInterface $id
    ) {}
}
