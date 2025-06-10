<?php

declare(strict_types=1);

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Model\ResupplyRequest;
use App\Groceries\Core\Model\ResupplyRequestedEvent;
use App\Groceries\Core\Port\Incoming\RequestResupplyCommand;
use App\Groceries\Core\Port\Outgoing\RequestResupplyRepository;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class RequestResupplyHandler
{
    public function __construct(
        private RequestResupplyRepository $repository,
        private MessageBusInterface $bus,
    ) {}

    public function __invoke(RequestResupplyCommand $command): void
    {
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
