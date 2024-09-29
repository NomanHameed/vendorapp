<?php

declare(strict_types=1);

namespace App\Lib\Handlers;

use Shopify\Webhooks\Handler;


class AppSession implements Handler
{
    public function handle(string $topic, string $shop, array $body): void
    {
        //
    }
}
