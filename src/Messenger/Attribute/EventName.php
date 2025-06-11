<?php

namespace App\Messenger\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class EventName
{
    public function __construct(public string $name) {}
}
