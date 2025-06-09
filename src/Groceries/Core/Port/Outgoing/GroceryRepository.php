<?php

declare(strict_types=1);

namespace App\Groceries\Core\Port\Outgoing;

interface GroceryRepository
{
    public function save(Grocery $grocery): void;

    public function getById(GroceryId $id): Grocery;
}
