<?php

declare(strict_types=1);

namespace App\Ordering\Core\Model\Event;

use Symfony\Component\Serializer\Attribute\SerializedName;

class OutstandingResupplyRequest
{
    public function __construct(
        #[SerializedName('vendor_id')]
        string $vendorId
    )
    {

    }
}
