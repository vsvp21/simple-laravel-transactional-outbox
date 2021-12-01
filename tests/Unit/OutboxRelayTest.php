<?php

declare(strict_types=1);

namespace Unit;

use PHPUnit\Framework\TestCase;
use Yuriykim\SimpleTransactionalOutbox\Fakes\FakeDispatcher;
use Yuriykim\SimpleTransactionalOutbox\Fakes\FakeEvent;
use Yuriykim\SimpleTransactionalOutbox\InMemoryOutboxRepository;
use Yuriykim\SimpleTransactionalOutbox\OutboxRelay;
use Yuriykim\SimpleTransactionalOutbox\ValueObject\OutboxMessage;

final class OutboxRelayTest extends TestCase
{
    private OutboxRelay $outboxRelay;
    private int $messagesCount;

    public function setUp(): void
    {
        $messages = [
            new OutboxMessage(FakeEvent::class, []),
            new OutboxMessage(FakeEvent::class, []),
            new OutboxMessage(FakeEvent::class, []),
            new OutboxMessage(FakeEvent::class, []),
        ];

        $this->messagesCount = count($messages);

        $outboxRepository = new InMemoryOutboxRepository();

        foreach ($messages as $message) {
            $outboxRepository->persist($message);
        }

        $this->outboxRelay = new OutboxRelay($outboxRepository, new FakeDispatcher());
    }

    public function testProcessMessages(): void
    {
        $this->assertEquals($this->messagesCount, $this->outboxRelay->handle());
    }
}