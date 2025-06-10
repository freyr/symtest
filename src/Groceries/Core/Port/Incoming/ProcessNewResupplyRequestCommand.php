<?php

declare(strict_types=1);

namespace App\Groceries\Core\Port\Incoming;

use Ramsey\Uuid\UuidInterface;

interface ProcessNewResupplyRequestCommand
{
    public UUidInterface $resupplyRequestId{get;}
}
