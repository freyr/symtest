<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Model\Product\ProductCatalog;
use App\Groceries\Core\Model\Product\Vendor\VendorCatalog;
use App\Groceries\Core\Port\Incoming\ProcessNewResupplyRequestCommand;
use App\Groceries\Core\Port\Outgoing\RequestResupplyRepository;
use App\Groceries\Core\Port\VendorPairingStrategy;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class ProcessNewResupplyRequestHandler
{

    public function __construct(
        private RequestResupplyRepository $repository,
        private ProductCatalog $productCatalog,
        private VendorCatalog $vendorCollection,
        private VendorPairingStrategy $vendorPairingStrategy,
        private MessageBusInterface $bus
    )
    {

    }
    public function __invoke(ProcessNewResupplyRequestCommand $command): void
    {
        $resupplyRequest = $this->repository->get($command->resupplyRequestId);
        $categoryId = $this->productCatalog->getCategoryId($resupplyRequest->productId);
        $vendors = $this->vendorCollection->filter($categoryId);
        $vendor = $this->vendorPairingStrategy->pair(
            $resupplyRequest,
            $vendors,
        );

        if ($vendor) {

            $this->bus->dispatch(
                // TODO: this should change to classic integration event
                new ResupplyRequestWasAssigned(

                ),
            );

            // TODO: this should additionaly keep selected vendor in resupplyRequest
            $resupplyRequest->assignVendor($vendor->id);
            $this->repository->save($resupplyRequest);
        }
    }
}
