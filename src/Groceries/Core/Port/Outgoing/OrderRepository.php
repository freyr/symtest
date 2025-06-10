<?php

declare(strict_types=1);

namespace App\Groceries\Core\Port\Outgoing;

use App\Groceries\Core\Model\Order\Order;

interface OrderRepository {
    public function save(Order $order): void;
}
