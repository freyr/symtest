<?php

declare(strict_types=1);

namespace App;

class Map
{
    public function __construct(private RouteCalculator $routeCalculator)
    {

    }

    public function calculateRoute(Point $from, Point $to, Mode $mode): Route
    {
        $meters = $this->routeCalculator->distance($from, $to, $mode);
        $seconds = $this->routeCalculator->time($from, $to, $mode);
    }
}
