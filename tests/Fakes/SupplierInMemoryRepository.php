<?php

declare(strict_types=1);

namespace App\Tests\Fakes;

use App\Groceries\Core\Model\Order\Supplier;
use App\Groceries\Core\Model\Order\SupplierId;
use App\Groceries\Core\Port\SupplierRepository;

class SupplierInMemoryRepository implements SupplierRepository
{
    public array $suppliers = [];

    public function save(Supplier $supplier): void
    {
        $this->suppliers[(string)$supplier->id->id] = $supplier;
    }

    public function get(SupplierId $supplierId): Supplier
    {
        return clone $this->suppliers[(string)$supplierId->id];
    }
}
