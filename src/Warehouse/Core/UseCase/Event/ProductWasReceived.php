<?php

declare(strict_types=1);

namespace App\Warehouse\Core\UseCase\Event;

use App\Warehouse\Core\Model\ProductId;
use App\Warehouse\Core\Model\Quantity;
use App\Warehouse\Core\Model\SupplierId;

readonly class ProductWasReceived {
    public function __construct(
        public ProductId $productId,
        public SupplierId $supplierId,
        public Quantity $quantity
    ) {}
}
