<?php

declare(strict_types=1);

namespace App\Tests\Fakes;

use App\Groceries\Core\Model\Order\Order;
use App\Groceries\Core\Port\Outgoing\OrderRepository;

class OrderInMemoryRepository implements OrderRepository
{
    /** @var array<string, Order> */
    public array $orders = [];

    public function save(Order $order): void
    {
        $this->orders[(string)$order->id->id] = $order;
    }
}
