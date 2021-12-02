<?php

declare(strict_types=1);

namespace Yuriykim\SimpleTransactionalOutbox\Fakes;

use Psr\EventDispatcher\EventDispatcherInterface;

final class FakeDispatcher implements EventDispatcherInterface
{
    /**
     * @inheritDoc
     */
    public function dispatch(object $event): void
    {
        echo "Dispatched {$event->payload['eventId']}\n";
    }
}
