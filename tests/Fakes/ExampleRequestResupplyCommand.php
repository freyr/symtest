<?php

declare(strict_types=1);

namespace App\Tests\Fakes;

use App\Groceries\Core\Model\ProductId;
use App\Groceries\Core\Model\Quantity;
use App\Groceries\Core\Model\Unit;
use App\Groceries\Core\Port\Incoming\RequestResupplyCommand;
use Ramsey\Uuid\Uuid;

class ExampleRequestResupplyCommand implements RequestResupplyCommand
{

    public ProductId $productId {
        get {
            return $this->productId;
        }
    }
    public Quantity $quantity {
        get {
            return new Quantity(1, Unit::KILOGRAM);
        }
    }

    public function __construct(
        ProductId $productId
    ) {
        $this->productId = $productId;
    }
}
