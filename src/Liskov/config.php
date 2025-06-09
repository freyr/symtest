<?php
declare(strict_types=1);
namespace App\Liskov;

$handler = new Handler();
$handler->handle(new Square());
$handler->handle(new Rectangle());
