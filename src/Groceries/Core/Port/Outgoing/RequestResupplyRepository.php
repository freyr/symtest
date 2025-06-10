<?php

declare(strict_types=1);

namespace App\Groceries\Core\Port\Outgoing;

use App\Groceries\Core\Model\ResupplyRequest;

interface RequestResupplyRepository
{

    public function save(ResupplyRequest $resupplyRequest): void;
}
