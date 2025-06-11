<?php

namespace App\Warehouse\Core\UseCase\ReadModel;

use App\Warehouse\Core\Port\WarehouseStateReportRepository;
use App\Warehouse\Core\UseCase\Event\ProductWasReceived;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'cqrs', handles: '*')]
class WarehouseReadModelSubscriber
{
    public function __construct(
        private WarehouseStateReportRepository $repository
    )
    {
    }

    public function __invoke(object $message): void
    {
        match(get_class($message)) {
            ProductWasReceived::class => $this->doProductReceived($message),
            default => throw new RuntimeException(sprintf('Unknown message "%s"', get_class($message))),
        };
    }

    private function doProductReceived(ProductWasReceived $message): void
    {
        $this->repository->save(
            $message->productId,
            $message->supplierId,
            $message->quantity
        );
    }

}
