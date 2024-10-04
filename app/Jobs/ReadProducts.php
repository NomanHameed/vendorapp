<?php

namespace App\Jobs;

use App\AppHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Shopify;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;

class ReadProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $domain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shop)
    {
        $this->domain = $shop;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $store = Store::where('domain', $this->domain)->first();

        $last_page = false;
        $params = array('limit' => 250);
        while (!$last_page) {
            $end_point = "products";
            $response = Shopify::call($store->token, $store->domain, $end_point, $params, 'GET');
            $header = AppHelper::getShopifyNextPageArray(Shopify::$headers);

            if (isset($response['products']) && count($response['products']) > 0) {
                $filename = 'products/' . str_replace('.myshopify.com', '', $store->domain) . '--' . $response['products'][0]['id'] . '.json';
                // Save as files
                Storage::disk('public')->put($filename, json_encode($response['products']));

                SyncProducts::dispatch($store->domain, $filename);
            }
            if (isset($header['next_page'])) {
                $params['page_info'] = $header['next_page'];
            }
            $last_page = $header['last_page'];
        }
    }


    // public function handlebk()
    // {
    //     $client = new Rest($this->shop, $this->token);
    //     $result = '';
    //     $prodcuts = [];
    //     do {
    //         $query = ['limit' => 5];

    //         if (!empty($result)) {
    //             $result = $client->get('products', [], $pageInfo->getNextPageQuery());
    //         } else {
    //             $result = $client->get('products', [], $query);
    //         }
    //         $pageInfo = unserialize(serialize($result->getPageInfo()));
    //         $nextPage = !empty($pageInfo) ? $pageInfo->hasNextPage() : false;

    //         // Get products from response
    //         $prodcuts = $result->getDecodedBody();

    //         $filename = str_replace('.myshopify.com', '', $this->shop) . '--' . $prodcuts['products'][0]['id'] . '.json';

    //         // Save as files
    //         Storage::disk('public')->put( 'products/' . $filename, json_encode($prodcuts['products']));

    //         SyncProducts::dispatch($this->shop, $filename);


    //     } while ($nextPage);
    // }
}
