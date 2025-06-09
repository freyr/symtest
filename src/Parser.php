<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

abstract class Parser
{
    public function __construct(private ?Parser $parser) {}

    public function parse(string $path, string $type): StructuredOrder
    {
        if ($this->isSatisfyBy($type)) {
            return $this->doParse($path);
        } else {
            if ($this->parser) {
                return $this->parser->parse($path, $type);
            } else {
                throw new RuntimeException('Incompatible type: ' . $type);
            }
        }
    }

    abstract protected function isSatisfyBy(string $type): bool;

    abstract protected function doParse(string $path): StructuredOrder;

}
