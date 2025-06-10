<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Resupply;

use App\Groceries\Core\Model\Product\Vendor\Vendor;
use App\Groceries\Core\Port\VendorPairingStrategy;

class FirstVendorPairingStrategy implements VendorPairingStrategy
{

    public function pair(ResupplyRequest $resupplyRequest, array $vendors): Vendor
    {
        return current($vendors);
    }
}
