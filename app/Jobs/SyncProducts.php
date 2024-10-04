<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Shopify\Clients\Rest;
use Illuminate\Support\Facades\Storage;

class SyncProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $domain;
    private $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shop, $file)
    {
        $this->domain = $shop;
        $this->filename = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $data = Storage::disk('public')->get( $this->filename );
        $store = Store::where('domain', $this->domain)->first();

        if(empty($data)) return;
        
        $products = json_decode($data, true);
        
        foreach($products as $product) {
            Product::manageProduct($product, $store);
        }

    }
}