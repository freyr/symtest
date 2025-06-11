<?php

declare(strict_types=1);

namespace App\Ordering\Core\Model\Order;

class Order
{
    /** @var array<OrderItem> */
    public array $orderItems;

    public function __construct(
        public readonly OrderId $id,
        public readonly Supplier $supplier,
    )
    {
        $this->orderItems = [];
    }

    public function addOrderItem(OrderItem $orderItem): void
    {
        $this->orderItems[] = $orderItem;
    }

    public function getOrderItems(): array
    {
        return $this->orderItems;
    }

}
