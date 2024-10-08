<?php

namespace App\Http\Controllers;

use App\AppHelper;
use App\Jobs\SyncProduct;
use App\Jobs\SyncProducts;
use App\Models\Product;
use App\Models\Shopify;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        $product->load('variants', 'options', 'vendor');
        return view('products.show', compact('product'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function sync(Product $product)
    {
        $store = Store::where('domain', 'nowtestapp.myshopify.com')->first();

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
        return redirect()->back();
    }

    public function shopifyUpdate(Product $product){
        $store = Store::latest()->first();
        $product = Product::find(1);
        $end_point = "products/". $product->shopify_product_id;
        $response = Shopify::call($store->token, $store->domain, $end_point, null, 'GET');
        $header = AppHelper::getShopifyNextPageArray(Shopify::$headers);

        if (isset($response['product']) && count($response['product']) > 0) {
            $filename = 'product/' . str_replace('.myshopify.com', '', $store->domain) . '--' . $response['product']['id'] . '.json';
            // Save as files
            Storage::disk('public')->put($filename, json_encode($response['product']));

            SyncProduct::dispatch($store->domain, $filename);
        }
        return redirect()->back()->with('success','Product Sync successfully');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(Product::query()->delete()){
            return redirect()->back();
        }

    }


}
