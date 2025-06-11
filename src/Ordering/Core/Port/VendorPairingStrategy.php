<?php

declare(strict_types=1);

namespace App\Ordering\Core\Port;

use App\Ordering\Core\Model\Resupply\ResupplyRequest;
use App\Ordering\Core\Model\Product\Vendor\Vendor;

interface VendorPairingStrategy {
    public function pair(ResupplyRequest $resupplyRequest, array $vendors): ?Vendor;
}
