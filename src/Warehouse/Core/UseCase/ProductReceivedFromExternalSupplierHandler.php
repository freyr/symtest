<?php

declare(strict_types=1);

namespace App\Warehouse\Core\UseCase;

use App\Warehouse\Core\Model\Product;
use App\Warehouse\Core\Model\Unit;
use App\Warehouse\Core\Port\ProductReceivedFromExternalSupplierCommand;
use App\Warehouse\Core\Port\ProductWarehouseRepository;
use App\Warehouse\Core\Port\WarehouseRepository;
use App\Warehouse\Core\UseCase\Event\ProductWasReceived;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductReceivedFromExternalSupplierHandler
{
    public function __construct(
        private WarehouseRepository $warehouseRepository,
        private ProductWarehouseRepository $productWarehouseCatalog,
        private MessageBusInterface $bus,
    ) {}

    public function __invoke(ProductReceivedFromExternalSupplierCommand $command): void
    {
        if ($this->warehouseRepository->exist($command->productId)) {
            $product = $this->warehouseRepository->get($command->productId, $command->supplierId);
        } else {
            $unit = $this->productWarehouseCatalog->getUnit($command->productId);
            $product = new Product(
                $command->productId,
                $command->supplierId,
                $unit
            );
        }

        $product->addQuantity($command->quantity);
        $this->bus->dispatch(
            new ProductWasReceived(
                (string)$command->productId,
            // TODO
            ),
        );
        $this->warehouseRepository->save($product);
    }
}
