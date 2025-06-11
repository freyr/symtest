<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Model\Product\Vendor\VendorId;
use App\Messenger\Attribute\EventName;
use JsonSerializable;

#[EventName('resupply.was_assigned')]
class ResupplyRequestWasAssigned implements JsonSerializable
{
    public function __construct(public VendorId $vendorId)
    {

    }

    public function jsonSerialize(): mixed
    {
        return [
            'vendor_id' => (string) $this->vendorId
        ];
    }
}
