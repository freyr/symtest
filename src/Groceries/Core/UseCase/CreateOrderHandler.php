<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

class CreateOrderHandler
{
    // TODO: this handler should be triggered by dedicated command that can be created manually on a web controller (POST /request-order)
    // or as a time-based action via CronJob
    public function __invoke(CreateNewOrderForResupplyRequest $command)
    {
        // TODO: Single Order can aggregate (by Vendor|Supplier?) multiple ResupplyRequest (that became in this case OrderItems)
        // After Order creation ResupplyRequests should be "Completed"
        $order = new Order(
            $command->resupplyRequest,
        );

        $this->repository->save($order);

        $this->bus->dispatch(new OrderCreatedEvent());
    }
}
