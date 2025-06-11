<?php

declare(strict_types=1);

namespace App\Warehouse\Core\Port;

use App\Warehouse\Core\Model\ProductId;
use App\Warehouse\Core\Model\Quantity;
use App\Warehouse\Core\Model\SupplierId;

interface ProductReceivedFromExternalSupplierCommand
{
    public ProductId $productId {get;}
    public Quantity $quantity {get;}
    public SupplierId $supplierId {get;}
}
