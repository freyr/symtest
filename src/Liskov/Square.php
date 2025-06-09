<?php

declare(strict_types=1);

namespace App\Liskov;

class Square extends Rectangle
{
    // Overrides so width and height stay equal
    public function setWidth(float $w): void
    {
        $this->width = $this->height = $w;
    }

    public function setHeight(float $h): void
    {
        $this->width = $this->height = $h;
    }
}
