<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Vendor;

use App\Groceries\Core\Model\Product\CategoryId;

class VendorCatalog
{
    /** @var array<string, Vendor> */
    private array $vendors;

    public function __construct(
        /** @var $vendors array<string, Vendor> */
        array $vendors,
    ) {
        foreach ($vendors as $vendor) {
            $this->vendors[$vendor->name] = $vendor;
        }
    }

    public function filter(CategoryId $categoryId): array
    {
        return array_filter(
            $this->vendors,
            fn(Vendor $vendor) => $vendor->provide($categoryId),
        );
    }

}
