<?php

declare(strict_types=1);

namespace App\Ordering\Core\Port;

use App\Ordering\Core\Model\Order\OutstandingRequest;
use App\Ordering\Core\Model\Order\RequestId;

interface OutstandingRequestRepository
{
    /** @return OutstandingRequest[] */
    public function getAll(): array;

    public function remove(RequestId $id): void;
}
