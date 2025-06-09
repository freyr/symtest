<?php

declare(strict_types=1);

namespace App;

class RouteCalculationStrategyFactory
{
    public function create(Mode $mode): RouteCalculator
    {
        return match ($mode->value) {
            'walking' => new WalkingRouteCalculator(),
            'car' => new CarRouteCalculator(),
            'train' => new TrainRouteCalculator(),
            'plane' => new PlaneRouteCalculator(),
        };
    }
}
