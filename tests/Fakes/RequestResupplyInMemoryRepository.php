<?php

declare(strict_types=1);

namespace App\Tests\Fakes;

use App\Groceries\Core\Model\ResupplyRequest;
use App\Groceries\Core\Port\Outgoing\RequestResupplyRepository;

class RequestResupplyInMemoryRepository implements RequestResupplyRepository
{

    public array $resupplyRequests = [];

    public function save(ResupplyRequest $resupplyRequest): void
    {
        $this->resupplyRequests[(string) $resupplyRequest->id] = $resupplyRequest;
    }
}
