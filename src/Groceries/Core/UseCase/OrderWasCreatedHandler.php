<?php

namespace App\Groceries\Core\UseCase;

use App\Groceries\Core\Message\OrderWasCreated;

final class OrderWasCreatedHandler
{
    public function __invoke(OrderWasCreated $message): void
    {

    }
}
