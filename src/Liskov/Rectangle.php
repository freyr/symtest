<?php

declare(strict_types=1);

namespace App\Liskov;

class Rectangle
{

    public float $width {
        get {
            return $this->width;
        }
        set {
            $this->width = $value;
        }
    }
    public float $height {
        get {
            return $this->height;
        }
        set {
            $this->height = $value;
        }
    }

    public function getArea(): float
    {
        return $this->width * $this->height;
    }
}
