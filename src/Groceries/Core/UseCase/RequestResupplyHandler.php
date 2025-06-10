<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Port\Incoming\RequestResupplyCommand;

class RequestResupplyHandler
{
    public function __invoke(RequestResupplyCommand $command): void
    {
        $resupplyRequest = new ResupplyRequest(
            $command->productId,
            $command->amount,
        );

        $this->repository->save($resupplyRequest);

        $this->bus->dispatch(new ResupplyRequestedEvent(
           $resupplyRequest
        ));
    }
}
