<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ResupplyRequest
{
    public UuidInterface $id;

    public function __construct(private ProductId $productId, private Quantity $quantity)
    {
        $this->id = UUid::uuid7();
    }
}
