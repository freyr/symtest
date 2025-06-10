<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Model\Order\Order;
use App\Groceries\Core\Model\Order\OrderId;
use App\Groceries\Core\Model\Order\OrderItem;
use App\Groceries\Core\Model\Order\SupplierId;
use App\Groceries\Core\Port\Incoming\CreateOrdersCommand;
use App\Groceries\Core\Port\Outgoing\OrderRepository;
use App\Groceries\Core\Port\Outgoing\RequestResupplyRepository;
use App\Groceries\Core\Port\SupplierRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class CreateOrderHandler
{
    public function __construct(
        private RequestResupplyRepository $resupplyRepository,
        private OrderRepository $repository,
        private SupplierRepository $supplierRepository,
        private MessageBusInterface $bus
    ) {}

    public function __invoke(CreateOrdersCommand $command): void
    {
        $outstandingRequests = $this->resupplyRepository->getOutstandingRequests();


        $orders = [];
        foreach ($outstandingRequests as $outstandingRequest) {

            $supplierId = SupplierId::fromVendorId($outstandingRequest->vendorId);
            if (!array_key_exists((string)$supplierId, $orders)) {
                $supplier = $this->supplierRepository->get($supplierId);
                $order = new Order(OrderId::new(), $supplier);
                $orders[(string)$supplierId] = $order;
            } else {
                /** @var Order $order */
                $order = $orders[(string)$supplierId];
            }

            $orderItem = new OrderItem();
            $order->addOrderItem($orderItem);
            $outstandingRequest->markAsExecuted();
            $this->resupplyRepository->save($outstandingRequest);
            $events[] = new OutstandingRequestWasExecuted();
        }

        foreach ($orders as $order) {
            $this->repository->save($order);
            $this->bus->dispatch(new OrderWasCreated());
        }

        foreach ($events as $event) {
            $this->bus->dispatch($event);
        }

    }
}
