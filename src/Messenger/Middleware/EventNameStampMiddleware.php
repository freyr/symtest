<?php

namespace App\Messenger\Middleware;

use App\Messenger\Attribute\EventName;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use ReflectionClass;

class EventNameStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();
        $reflection = new ReflectionClass($message);
        $attributes = $reflection->getAttributes(EventName::class);
        if ($attributes) {
            /** @var EventName $eventNameAttr */
            $eventNameAttr = $attributes[0]->newInstance();
            $envelope = $envelope->with(
                new AmqpStamp(null, AMQP_NOPARAM, ['eventName' => $eventNameAttr->name])
            );
        }
        return $stack->next()->handle($envelope, $stack);
    }
}
