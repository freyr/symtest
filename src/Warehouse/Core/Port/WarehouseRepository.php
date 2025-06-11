<?php

declare(strict_types=1);

namespace App\Warehouse\Core\Port;

use App\Warehouse\Core\Model\Product;
use App\Warehouse\Core\Model\ProductId;
use App\Warehouse\Core\Model\SupplierId;

interface WarehouseRepository {
    public function save(Product $product): void;

    public function exist(ProductId $productId): bool;

    public function get(ProductId $productId, SupplierId $supplierId): Product;
}
