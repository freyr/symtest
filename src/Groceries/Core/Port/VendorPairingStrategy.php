<?php

declare(strict_types=1);

namespace App\Groceries\Core\Port;

use App\Groceries\Core\Model\Resupply\ResupplyRequest;
use App\Groceries\Core\Model\Product\Vendor\Vendor;

interface VendorPairingStrategy {
    public function pair(ResupplyRequest $resupplyRequest, array $vendors): ?Vendor;
}
