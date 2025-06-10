<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Port\Outgoing\CreateNewOrderForResupplyRequest;

class CreateOrderHandler
{
    public function __invoke(CreateNewOrderForResupplyRequest $command)
    {
        $order = new Order(
            $command->resupplyRequest,
        );

        $this->repository->save($order);

        $this->bus->dispatch(new OrderCreatedEvent());
    }
}
