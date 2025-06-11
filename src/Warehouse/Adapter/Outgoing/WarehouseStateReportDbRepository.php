<?php

declare(strict_types=1);

namespace App\Warehouse\Adapter\Outgoing;

use App\Warehouse\Core\Model\ProductId;
use App\Warehouse\Core\Model\Quantity;
use App\Warehouse\Core\Model\SupplierId;
use App\Warehouse\Core\Port\WarehouseStateReportRepository;
use Doctrine\DBAL\Connection;

class WarehouseStateReportDbRepository implements WarehouseStateReportRepository
{
    public function __construct(
        private Connection $connection
    )
    {

    }

    public function save(ProductId $productId, SupplierId $supplierId, Quantity $quantity): void
    {
        $sql = 'select name from product_catalog where product_id = :product_id';
        $productName = $this->connection->fetchOne($sql, ['product_id' => $productId]);

        $sql = 'select name from supplier_catalog where supplier_id = :supplier_id';
        $supplierName = $this->connection->fetchOne($sql, ['supplier_id' => $supplierId]);

        $sql = 'insert into warehouse_state_report
                (product_id, supplier_id, quantity, unit)
                values (:product_id, :supplier_id, :product_name, :supplier_name, :quantity, :unit)';

        $this->connection->executeQuery($sql, [
            'product_id' => $productId,
            'supplier_id' => $supplierId,
            'product_name' => $productName,
            'supplier_name' => $supplierName,
            'quantity' => $quantity->getQty(),
            'unit' => $quantity->unit,
        ]);

    }

}
