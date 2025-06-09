<?php

declare(strict_types=1);

namespace App;

class XMLParser extends Parser
{

    protected function doParse(string $path): StructuredOrder
    {
        return new StructuredOrder();
    }

    function isSatisfyBy(string $type): bool
    {
        return 'xml' === $type;
    }
}
