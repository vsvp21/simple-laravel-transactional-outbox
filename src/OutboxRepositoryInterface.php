<?php

declare(strict_types=1);

namespace Yuriykim\SimpleTransactionalOutbox;

use Yuriykim\SimpleTransactionalOutbox\ValueObject\OutboxMessage;

interface OutboxRepositoryInterface
{
    /**
     * @return OutboxMessage[]
     */
    public function retrieve(): array;
    public function persist(OutboxMessage $message): void;
    public function delete(OutboxMessage ...$messages): void;
}
