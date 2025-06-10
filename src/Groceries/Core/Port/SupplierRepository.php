<?php

declare(strict_types=1);

namespace App\Groceries\Core\Port;

use App\Groceries\Core\Model\Order\Supplier;
use App\Groceries\Core\Model\Order\SupplierId;

interface SupplierRepository
{
    public function get(SupplierId $supplierId): Supplier;
}
