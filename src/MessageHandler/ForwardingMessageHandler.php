<?php

namespace App\MessageHandler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;

#[AsMessageHandler(fromTransport: 'inbox', handles: '*')]
class ForwardingMessageHandler
{
  private MessageBusInterface $bus;

  public function __construct(MessageBusInterface $bus)
  {
    $this->bus = $bus;
  }

  public function __invoke(object $message): void
  {
    $this->bus->dispatch(
      new Envelope(
        $message,
        [new TransportNamesStamp('async')],
      ),
    );
  }
}
