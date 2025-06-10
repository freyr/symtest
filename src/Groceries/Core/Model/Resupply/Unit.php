<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Resupply;

enum Unit : string
{
    case KILOGRAM = 'kg';
    case LITER = 'l';
    case PIECE = 'pcs';

}
