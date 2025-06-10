<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Port\Incoming\ProcessNewResupplyRequestCommand;

class ProcessNewResupplyRequestHandler
{
    public function __invoke(ProcessNewResupplyRequestCommand $command)
    {
        $categoryId = $this->productCatalog->getCategoryId($command->productId);
        $vendors = $this->vendorCollection->filter($categoryId);
        $vendor = $this->vendorPairingStrategy->pair($command->productId, $command->amount, $vendors);
        if ($vendor) {
            $order = new ResupplyOrder();
            $this->
            $this->bus->dispatch(
                new ResuplyOrderCreated(
                    $order,
                ),
            );
            // mark resupply request as "executed"
        }
    }
}
