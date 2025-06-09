<?php

declare(strict_types=1);

namespace App;

class WalkingRouteCalculator implements RouteCalculator
{
    public function __construct() {}

    public function distance(Point $from, Point $to, Mode $mode): int
    {
        // TODO: Implement distance() method.
    }

    public function time(Point $from, Point $to, Mode $mode): int
    {
        // TODO: Implement time() method.
    }
}
