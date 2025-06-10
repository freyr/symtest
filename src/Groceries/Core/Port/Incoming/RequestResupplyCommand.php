<?php

declare(strict_types=1);

namespace App\Groceries\Core\Port\Incoming;

interface RequestResupplyCommand
{
    public string $productId {get;}
    public Amount $amount {get;}
}
