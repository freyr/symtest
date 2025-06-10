<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Resupply;

enum ResupplyRequestStatus: string
{
    case New = 'new';
    case Assigned = 'assigned';
    case Executed = 'executed';
}
