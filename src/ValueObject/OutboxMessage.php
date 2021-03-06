<?php

declare(strict_types=1);

namespace Yuriykim\SimpleTransactionalOutbox\ValueObject;

use Illuminate\Support\Str;
use UnexpectedValueException;

/**
 * @psalm-immutable
 */
final class OutboxMessage
{
    public string $eventId;

    /**
     * @param string $eventType
     * @psalm-param class-string $eventType
     * @param array $payload
     * @param string|null $eventId
     *
     * @throws UnexpectedValueException
     */
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
