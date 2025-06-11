<?php

declare(strict_types=1);

namespace App\Warehouse\Core\Port;

use App\Warehouse\Core\Model\ProductId;
use App\Warehouse\Core\Model\Quantity;
use App\Warehouse\Core\Model\SupplierId;

interface WarehouseStateReportRepository
{
    public function save(ProductId $productId, SupplierId $supplierId, Quantity $quantity): void;
}
