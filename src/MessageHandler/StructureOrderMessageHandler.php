<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\JsonParser;
use App\XMLParser;

class StructureOrderMessageHandler
{

    public function __invoke(StructuredOrderMessage $message): void
    {
        $parser = new XMLParser(new JsonParser(null));
        $structuredOrder = $parser->parse($message->path, $message->type);
    }
}
