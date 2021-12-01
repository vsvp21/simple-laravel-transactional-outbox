<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Transactional Outbox Repository
    |--------------------------------------------------------------------------
    |
    | This option indicates which repository to use to query the outbox table
    |
    */
    'repository' => \Yuriykim\SimpleTransactionalOutbox\IlluminateOutboxRepository::class,
];