<?php

declare(strict_types=1);

namespace Unit;

use PHPUnit\Framework\TestCase;
use Yuriykim\SimpleTransactionalOutbox\Fakes\FakeEvent;
use Yuriykim\SimpleTransactionalOutbox\ValueObject\OutboxMessage;

final class OutboxMessageTest extends TestCase
{
    /**
     * @dataProvider outboxMessageDataProvider
     */
    public function testCreateOutboxMessage(string $eventType, array $payload, ?string $eventId = null): void
    {
        $outboxMessage = new OutboxMessage($eventType, $payload, $eventId);

        $this->assertEquals($eventType, $outboxMessage->eventType);
        $this->assertEquals($payload, $outboxMessage->payload);
        $this->assertNotNull($outboxMessage->eventId);
    }

    /**
     * @dataProvider outboxMessageDataProvider
     */
    public function testOutboxMessageToArray(string $eventType, array $payload, ?string $eventId = null): void
    {
        $outboxMessage = new OutboxMessage($eventType, $payload, $eventId);

        $outboxMessageAsArray = $outboxMessage->toArray();

        $this->assertEquals([
            'eventId' => $outboxMessage->eventId,
            'eventType' => $outboxMessage->eventType,
            'payload' => $outboxMessage->payload,
        ], $outboxMessageAsArray);
    }

    public function testUuidMismatchException(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        new OutboxMessage(FakeEvent::class, [], 'Not-An-UUIDv4-Identifier');
    }

    public function outboxMessageDataProvider(): array
    {
        return [
            [
                'event_type' => FakeEvent::class,
                'payload' => ['test' => 'test'],
                'event_id' => '18059392-d004-4d6c-9d22-b5449e663d89',
            ],
            [
                'event_type' => FakeEvent::class,
                'payload' => ['test' => 'test'],
            ],
        ];
    }
}
