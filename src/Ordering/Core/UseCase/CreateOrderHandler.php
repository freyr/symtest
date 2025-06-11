<?php

declare(strict_types=1);

namespace App\Ordering\Core\UseCase;

use App\Ordering\Core\Model\Order\Order;
use App\Ordering\Core\Model\Order\OrderId;
use App\Ordering\Core\Model\Order\OrderItem;
use App\Ordering\Core\Model\Order\SupplierId;
use App\Ordering\Core\Port\Incoming\CreateOrdersCommand;
use App\Ordering\Core\Port\Outgoing\OrderRepository;
use App\Ordering\Core\Port\Outgoing\RequestResupplyRepository;
use App\Ordering\Core\Port\OutstandingRequestRepository;
use App\Ordering\Core\Port\SupplierRepository;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class CreateOrderHandler
{
    public function __construct(
        private OutstandingRequestRepository $resupplyRepository,
        private OrderRepository $repository,
        private SupplierRepository $supplierRepository,
        private MessageBusInterface $bus
    ) {}

    public function __invoke(CreateOrdersCommand $command): void
    {
        $outstandingRequests = $this->resupplyRepository->getAll();
        $orders = [];
        $events = [];
        foreach ($outstandingRequests as $outstandingRequest) {
            if (!array_key_exists((string)$outstandingRequest->supplierId, $orders)) {
                $supplier = $this->supplierRepository->get($outstandingRequest->supplierId);
                $order = new Order(OrderId::new(), $supplier);
                $orders[(string)$outstandingRequest->supplierId] = $order;
            } else {
                /** @var Order $order */
                $order = $orders[(string)$outstandingRequest->supplierId];
            }

            $orderItem = new OrderItem();
            $order->addOrderItem($orderItem);
            $this->resupplyRepository->remove($outstandingRequest->id);
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
