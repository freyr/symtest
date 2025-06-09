<?php

declare(strict_types=1);

namespace App\MessageHandler;

readonly class StructuredOrderMessage
{
  public function __construct(
    public string $type,
    public string $path

  )
  {

  }
}
