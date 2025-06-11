<?php

declare(strict_types=1);

namespace App\Warehouse\Core\Port;

use App\Warehouse\Core\Model\ProductId;
use App\Warehouse\Core\Model\Unit;

interface ProductWarehouseRepository {
    public function getUnit(ProductId $productId): Unit;
}
