<?php

declare(strict_types=1);

namespace App\Warehouse\Core\Model;

enum Unit: string
{
    case PCS = 'pcs';
    case Pack = 'pack';
}
