<?php

declare(strict_types=1);

namespace App\Ordering\Core\Model\Order;

class OutstandingRequest {
    public SupplierId$supplierId {
        get => $this->supplierId;
    }
    public RequestId $id {
        get => $this->id;
    }
}
