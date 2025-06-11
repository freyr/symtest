<?php

declare(strict_types=1);

namespace App\Warehouse\Core\UseCase;

use App\Warehouse\Core\Port\ProductSoldCommand;
use App\Warehouse\Core\Port\ProductWarehouseRepository;
use App\Warehouse\Core\Port\WarehouseRepository;
use App\Warehouse\Core\UseCase\Event\ProductWasReceived;
use App\Warehouse\Core\UseCase\Event\ProductWasSoldReceived;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductSoldHandler
{

    public function __construct(
        private WarehouseRepository $warehouseRepository,
        private MessageBusInterface $bus,
    ) {}

    public function __invoke(ProductSoldCommand $command)
    {
        $product = $this->warehouseRepository->get($command->productId, $command->supplierId);
        $product->removeQuantity($command->quantity);

        $this->bus->dispatch(
            new ProductWasSoldReceived(
                (string)$command->productId,
            // TODO
            ),
        );
        $this->warehouseRepository->save($product);
    }
}
