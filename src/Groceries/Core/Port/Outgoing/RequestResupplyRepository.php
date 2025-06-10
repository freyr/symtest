<?php

declare(strict_types=1);

namespace App\Groceries\Core\Port\Outgoing;

use App\Groceries\Core\Model\Resupply\ResupplyRequest;
use Ramsey\Uuid\UuidInterface;

interface RequestResupplyRepository
{

    public function save(ResupplyRequest $resupplyRequest): void;

    public function get(UuidInterface $resupplyRequestId): ResupplyRequest;

    /** @return ResupplyRequest[] */
    public function getOutstandingRequests(): array;
}
