<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class ParserFactory
{
  public static function create(string $type): Parser
  {
    return match ($type) {
      'xml' => new XMLParser(),
      'json' => new JsonParser(),
      default => throw new InvalidArgumentException('Invalid type'),
    };
  }
}
