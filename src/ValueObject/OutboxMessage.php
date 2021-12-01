<?php

declare(strict_types=1);

namespace Yuriykim\SimpleTransactionalOutbox\ValueObject;

use Illuminate\Support\Str;
use UnexpectedValueException;

final class OutboxMessage
{
    public string $eventId;

    public function __construct(public string $eventType, public array $payload, ?string $eventId = null)
    {
        if (! $eventId) {
            $eventId = Str::uuid()->toString();
        }

        if (! Str::isUuid($eventId)) {
            throw new UnexpectedValueException('Value must be in UUID v4 format');
        }

        $this->eventId = $eventId;
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
