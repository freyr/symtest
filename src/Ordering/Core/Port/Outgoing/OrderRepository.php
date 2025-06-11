<?php

declare(strict_types=1);

namespace App\Ordering\Core\Port\Outgoing;

use App\Ordering\Core\Model\Order\Order;

interface OrderRepository {
    public function save(Order $order): void;
}
