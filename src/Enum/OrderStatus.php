<?php

namespace App\Enum;

enum OrderStatus: string
{
    case NEW = 'new';
    case INPROGRESS = 'inprogress';
    case ACCEPTED = 'accepted';
    case CONFIRMED = 'confirmed';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
}
