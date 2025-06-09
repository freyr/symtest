<?php

declare(strict_types=1);

namespace App;

class RouteCalculatorFactory implements RouteCalculator
{
    public function __construct(private RouteCalculationStrategyFactory $factory)
    {

    }

    public function distance(Point $from, Point $to, Mode $mode): int
    {
        return $this->factory->create($mode)->distance($from, $to);
        // TODO: Implement distance() method.
    }

    public function time(Point $from, Point , Mode $mode): int
    {
        return $this->factory->create($mode)->distance($from, $to);
    }
}
