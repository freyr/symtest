<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Port\Incoming\ProcessNewResupplyRequestCommand;
use App\Groceries\Core\Port\Outgoing\CreateNewOrderForResupplyRequest;

class ProcessNewResupplyRequestHandler
{
    public function __invoke(ProcessNewResupplyRequestCommand $command)
    {
        $resupplyRequest = $this->repository->get($command->resupplyRequestId);
        $categoryId = $this->productCatalog->getCategoryId($command->productId);
        $vendors = $this->vendorCollection->filter($categoryId);
        $vendor = $this->vendorPairingStrategy->pair(
            $command->productId,
            $command->amount,
            $vendors
        );

        if ($vendor) {

            $this->bus->dispatch(
                new CreateNewOrderForResupplyRequest(

                ),
            );

            $resupplyRequest->markAsExecuted();
            $this->repository->save(
                $resupplyRequest,
            );
        }
    }
}
