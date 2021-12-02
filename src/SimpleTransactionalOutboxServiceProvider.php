<?php

declare(strict_types=1);

namespace Yuriykim\SimpleTransactionalOutbox;

use Illuminate\Support\ServiceProvider;

final class SimpleTransactionalOutboxServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(OutboxRepositoryInterface::class, config('outbox.repository'));
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../config/outbox.php' => config_path('outbox.php')
        ]);
    }
}
