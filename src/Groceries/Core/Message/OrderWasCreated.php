<?php

namespace App\Groceries\Core\Message;

final class OrderWasCreated
{
    public function __construct(
        public string $eventName,
        public string $orderId,
        public string $customerId,
        public array $items,
    ) {}
}
