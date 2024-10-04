<?php

namespace App\Jobs;

use App\Models\Collection;
use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CollectionSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $domain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $store = Store::where('domain', $this->domain)->first();

        // Collection::syncSmartCollections($store);
        // Collection::syncCustomCollections($store);
        // Collection::syncCustomCollectionsProducts($store);
        // Collection::syncSmartCollectionsProducts($store);
        Collection::syncCollectionProducts($store);

    }
}
