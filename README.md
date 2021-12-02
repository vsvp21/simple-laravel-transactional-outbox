# Simple PHP Laravel Transactional Outbox using Polling Publisher Pattern

## Installation

You can install the package via composer:

```bash
composer require yuriykim/simple-transactional-outbox
```

Then publish the config
```bash
php artisan vendor:publish --provider="Yuriykim\SimpleTransactionalOutbox\SimpleTransactionalOutboxServiceProvider"
```

Set provider to app.php config
```php
[
    /*
    * Package Service Providers...
    */
    Yuriykim\SimpleTransactionalOutbox\SimpleTransactionalOutboxServiceProvider::class,
]
```
<br>
If you want to use your own Outbox Repository Then simply change outbox.php config file

```php
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
    'repository' => \Yuriykim\SimpleTransactionalOutbox\IlluminateOutboxRepository::class, // change this to your own repository if you need
];
```

## Usage

You can run Outbox Relay like a php daemon via supervisord/circus or even like a cron job

<br>

Sample code:

```php
<?php

use Yuriykim\SimpleTransactionalOutbox\OutboxRelay;

final class ProcessOutboxMessages
{
    public function __construct(private OutboxRelay $outboxRelay)
    {    
    }

    public function handle(): void
    {
        $this->outboxRelay->handle();    
    }
}
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.