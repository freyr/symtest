<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model;

use Ramsey\Uuid\UuidInterface;

readonly class ProductId
{
    public function __construct(
        public UUidInterface $id
    ) {}
}
