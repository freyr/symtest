<?php

declare(strict_types=1);

namespace App\Tests\Fakes;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class MessageBusInMemory implements MessageBusInterface
{
    public array $messages = [];

    public function dispatch(object $message, array $stamps = []): Envelope
    {
        $this->messages[] = $message;
        return Envelope::wrap($message);
    }
}
