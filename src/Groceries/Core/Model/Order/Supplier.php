<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Order;

class Supplier
{
    public function __construct(
        public readonly SupplierId $id,
        public readonly string $name,
    )
    {

    }
}
