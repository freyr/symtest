<?php

declare(strict_types=1);

namespace App\Ordering\Core\UseCase;


use App\Messenger\Attribute\EventName;

#[EventName('order.was_created')]
class OrderWasCreated {
    public function __construct() {}
}
