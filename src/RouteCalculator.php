<?php

declare(strict_types=1);

namespace App;

interface RouteCalculator
{
    public function distance(Point $from, Point $to, Mode $mode): int;

    public function time(Point $from, Point $to, Mode $mode): int;
}
