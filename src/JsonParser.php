<?php

declare(strict_types=1);

namespace App;

class JsonParser extends Parser
{
    protected function doParse(string $path): StructuredOrder
    {
        return new StructuredOrder();
    }


    function isSatisfyBy(string $type): bool
    {
        return 'json' === $type;
    }
}
