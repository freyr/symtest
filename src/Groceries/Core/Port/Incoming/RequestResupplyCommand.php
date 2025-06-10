<?php

declare(strict_types=1);

namespace App\Groceries\Core\Port\Incoming;

use App\Groceries\Core\Model\Product\ProductId;
use App\Groceries\Core\Model\Resupply\Quantity;

interface RequestResupplyCommand
{
    public ProductId $productId {get;}
    public Quantity $quantity {get;}
}
