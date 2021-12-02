<?php

declare(strict_types=1);

namespace Yuriykim\SimpleTransactionalOutbox;

use Psr\EventDispatcher\EventDispatcherInterface;

final class OutboxRelay
{
    private const TRIES = 3;

    public function __construct(
        private OutboxRepositoryInterface $outboxRepository,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function handle(): int
    {
        $messages = $this->outboxRepository->retrieve();
        $publishedMessages = [];

        foreach ($messages as $message) {
            retry(self::TRIES, function () use ($message, &$publishedMessages) {
                $event = $message->eventType;

                $this->eventDispatcher->dispatch(new $event($message->toArray()));
                $publishedMessages[] = $message;
            });
        }

        $publishedMessagesCount = count($publishedMessages);

        if ($publishedMessagesCount > 0) {
            $this->outboxRepository->delete(...$publishedMessages);
        }

        return $publishedMessagesCount;
    }
}
