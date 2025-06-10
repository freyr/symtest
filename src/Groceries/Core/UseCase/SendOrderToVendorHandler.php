<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Port\Incoming\SendOrderToVendorCommand;

class SendOrderToVendorHandler
{
    public function __invoke(SendOrderToVendorCommand $command)
    {

        $order = $this->repository->find($command->orderId);
        $status = $this->service->placeOrder($order);
        if ($status === Status::PLACED()) {
            $order->markAsDeliveredToVendor();
            $this->repository->save($order);

            $this->bus->dispatch(new OrderDeliveredToVendorEvent());
        }
    }
}
