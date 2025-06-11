<?php

namespace App\Groceries\Adapter;

use App\Groceries\Core\Message\OrderWasCreated;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

class EventJsonSerializer implements SerializerInterface
{
    private SymfonySerializerInterface $serializer;

    public function __construct(SymfonySerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    private array $eventMap = [
        'order.was_created' => OrderWasCreated::class,
        'resupply.was_assigned' => OutsandingRequestReceived::class,
    ];

    public function decode(array $encodedEnvelope): Envelope
    {
        $data = json_decode($encodedEnvelope['body'], true);
        $headers = $encodedEnvelope['headers'] ?? [];
        $eventName = $headers['eventName'] ?? null;
        $class = $this->eventMap[$eventName] ?? null;
        if (!$class) {
            throw new \InvalidArgumentException("Unknown eventName: $eventName");
        }

        $message = $this->serializer->denormalize($data, $class);
        return new Envelope($message);
    }

    public function encode(Envelope $envelope): array
    {
        return [
            'body' => json_encode($envelope->getMessage(), JSON_THROW_ON_ERROR),
            'headers' => [],
        ];
    }
}
