<?php

namespace App\Traits;

use App\Models\CollectionProduct;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProductVariant;

trait ProductWebhookListenTrait
{
    /**
     * Create-Order web Hooks
     */
    public function createForWebHook()
    {

        $product = json_decode(file_get_contents('php://input'), true);
        $storeQuery = Store::whereDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($storeQuery->exists()) {
            // $store = $storeQuery->first();
            // $store_id = strval(trim($store->store_id));
            // $product_id = strval(trim($product['id']));
            // Product::manageProduct($product, $store);
            // if (isset($product['variants']) && count($product['variants'])) {
            //     Product::manageVariants($product['variants'], $store);
            // }
            // $this->getProductCustomCollections($product_id, $store);
            // $this->getProductSmartCollections($product_id, $store);

        }
    }

    /**
     * WebHook Update Product
     */
    public function updateForWebHook()
    {
        $product = json_decode(file_get_contents('php://input'), true);
        $storeQuery = Store::whereDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($storeQuery->exists()) {
            $store = $storeQuery->first();
            $product_id = strval(trim($product['id']));
            $store_id = strval(trim($store->store_id));
            Product::manageProduct($product, $store);

            if (isset($product['variants']) && count($product['variants'])) {
                Product::manageVariants($product['variants'], $store);
                $deleted_variants_array = array();
                foreach ($product['variants'] as $variant) {
                    $variant_id = strval(trim($variant['id']));
                    array_push($deleted_variants_array, $variant_id);
                }
                ProductVariant::whereNotIn('variant_id', $deleted_variants_array)
                    ->where('shopify_product_id', $product_id)
                    ->where('store_id', $store_id)
                    ->delete();
            }
            $this->getProductCustomCollections($product_id, $store);
            $this->getProductSmartCollections($product_id, $store);
        }

        echo 'ok';
    }

    /**
     * WebHook Delete Product
     */
    public function deleteForWebHook()
    {
        $product_id = json_decode(file_get_contents('php://input'), true)['id'];
        $storeQuery = Store::whereDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);

        if ($storeQuery->exists()) {

            $store = $storeQuery->first();
            $product_id = strval(trim($product_id));
            $store_id = strval(trim($store->store_id));

            CollectionProduct::where('product_id', $product_id)->where('store_id', $store_id)->delete();
            ProductVariant::where('shopify_product_id', $product_id)->where('store_id', $store_id)->delete();
            Product::where('shopify_product_id', $product_id)->where('store_id', $store_id)->delete();
        }
    }
}
