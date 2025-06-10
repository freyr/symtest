<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Resupply;

class ResupplyRequestedEvent
{
    public function __construct(private ResupplyRequest $resupplyRequest) {}
}
