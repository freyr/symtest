<?php

declare(strict_types=1);

namespace App\Tests\Fakes;

use App\Groceries\Core\Model\Resupply\ResupplyRequest;
use App\Groceries\Core\Model\Resupply\ResupplyRequestStatus;
use App\Groceries\Core\Port\Outgoing\RequestResupplyRepository;
use Ramsey\Uuid\UuidInterface;

class RequestResupplyInMemoryRepository implements RequestResupplyRepository
{

    public array $resupplyRequests = [];

    public function save(ResupplyRequest $resupplyRequest): void
    {
        $this->resupplyRequests[(string)$resupplyRequest->id] = $resupplyRequest;
    }

    public function get(UuidInterface $resupplyRequestId): ResupplyRequest
    {
        return clone $this->resupplyRequests[(string)$resupplyRequestId];
    }

    public function getOutstandingRequests(): array
    {
        return array_filter(
            $this->resupplyRequests,
            fn(ResupplyRequest $resupplyRequest) => $resupplyRequest->status === ResupplyRequestStatus::Assigned
        );
    }
}
