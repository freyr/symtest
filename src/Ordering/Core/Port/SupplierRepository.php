<?php

declare(strict_types=1);

namespace App\Ordering\Core\Port;

use App\Ordering\Core\Model\Order\Supplier;
use App\Ordering\Core\Model\Order\SupplierId;

interface SupplierRepository
{
    public function get(SupplierId $supplierId): Supplier;
}
