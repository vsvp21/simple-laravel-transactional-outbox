<?php

declare(strict_types=1);

namespace Yuriykim\SimpleTransactionalOutbox\Fakes;

/**
 * @psalm-immutable
 */
final class FakeEvent
{
    public function __construct(public array $payload)
    {
    }
}
