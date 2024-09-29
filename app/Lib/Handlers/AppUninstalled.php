<?php

declare(strict_types=1);

namespace App\Lib\Handlers;

use Shopify\Webhooks\Handler;
use App\Models\Session;

class AppUninstalled implements Handler
{
    public function handle(string $topic, string $shop, array $body): void
    {
            Session::where('shop', $shop)->delete();
    }
}
