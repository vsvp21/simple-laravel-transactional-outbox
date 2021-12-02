<?php

declare(strict_types=1);

namespace Yuriykim\SimpleTransactionalOutbox;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yuriykim\SimpleTransactionalOutbox\ValueObject\OutboxMessage;

final class IlluminateOutboxRepository implements OutboxRepositoryInterface
{
    public function retrieve(): array
    {
        return DB::table('outbox')
            ->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
            ->orderBy('created_at')
            ->get()
            ->map(fn (object $message) => new OutboxMessage($message->event_type, json_decode($message->payload, true), $message->event_id))
            ->toArray();
    }

    public function persist(OutboxMessage $message): void
    {
        DB::table('outbox')
            ->insert([
                'event_id' => $message->eventId,
                'event_type' => $message->eventType,
                'payload' => json_encode($message->payload),
                'created_at' => Carbon::now(),
            ]);
    }

    public function delete(OutboxMessage ...$messages): void
    {
        DB::transaction(fn () => DB::table('outbox')
            ->whereIn('event_id', array_map(fn (OutboxMessage $message) => $message->eventId, $messages))
            ->delete());
    }
}
