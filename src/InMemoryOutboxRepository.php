<?php

declare(strict_types=1);

namespace Yuriykim\SimpleTransactionalOutbox;

use Yuriykim\SimpleTransactionalOutbox\ValueObject\OutboxMessage;

final class InMemoryOutboxRepository implements OutboxRepositoryInterface
{
    private array $messages = [];

    /**
     * @inheritDoc
     */
    public function retrieve(): array
    {
        return $this->messages;
    }

    public function persist(OutboxMessage $message): void
    {
        $this->messages[$message->eventId] = $message;
    }

    public function delete(OutboxMessage ...$messages): void
    {
        foreach ($messages as $message) {
            unset($messages[$message->eventId]);
        }
    }
}