<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Order;

use App\Groceries\Core\Model\Product\Vendor\VendorId;
use Freyr\Identity\Id;

class SupplierId extends Id {
    public static function fromVendorId(VendorId $vendorId): self
    {
        return SupplierId::fromString((string)$vendorId->id);
    }

}
