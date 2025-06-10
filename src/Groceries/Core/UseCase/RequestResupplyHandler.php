<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Model\Product\ProductCatalog;
use App\Groceries\Core\Model\Resupply\ResupplyRequest;
use App\Groceries\Core\Model\Resupply\ResupplyRequestedEvent;
use App\Groceries\Core\Port\Incoming\RequestResupplyCommand;
use App\Groceries\Core\Port\Outgoing\RequestResupplyRepository;
use RuntimeException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class RequestResupplyHandler
{
    public function __construct(
        private RequestResupplyRepository $repository,
        private MessageBusInterface $bus,
        private ProductCatalog $productCatalog
    ) {}

    public function __invoke(RequestResupplyCommand $command): void
    {
        if (!$this->productCatalog->exist($command->productId)) {
            throw new RuntimeException('Product do not exist.');
        }

        $resupplyRequest = new ResupplyRequest(
            $command->productId,
            $command->quantity,
        );

        $this->repository->save($resupplyRequest);

        $this->bus->dispatch(
            new ResupplyRequestedEvent(
                $resupplyRequest,
            ),
        );
    }
}
