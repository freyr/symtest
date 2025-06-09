<?php

declare(strict_types=1);

namespace App\Liskov;

class Handler
{
    public function handle(Rectangle $rectangle): float
    {
        $rectangle->width = 10;
        $rectangle->height = 8;
        return $rectangle->getArea();
    }
}
