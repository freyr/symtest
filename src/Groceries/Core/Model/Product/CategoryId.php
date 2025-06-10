<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Product;

use Ramsey\Uuid\UuidInterface;

class CategoryId
{
    public function __construct(
        public UUidInterface $id
    ) {}
}
