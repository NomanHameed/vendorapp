<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'store_id',
        'shopify_product_id',
        'title',
        'body_html',
        'vendor',
        'product_type',
        'handle',
        'template_suffix',
        'published_scope',
        'tags',
        'status',
        'published_at',
        'admin_graphql_api_id'
    ];

    public static function manageProduct($productData, $store){
        $existingProduct = Product::where('shopify_product_id', $productData['id'])->first();

        if ($existingProduct) {
            $existingProduct->title = $productData['title'];
            $existingProduct->body_html = $productData['body_html'];
            $existingProduct->vendor = $productData['vendor'];
            $existingProduct->product_type = $productData['product_type'];
            $existingProduct->handle = $productData['handle'];
            $existingProduct->template_suffix = $productData['template_suffix'];
            $existingProduct->published_scope = $productData['published_scope'];
            $existingProduct->tags = $productData['tags'];
            $existingProduct->status = $productData['status'];
            $existingProduct->published_at = $productData['published_at'];
            $existingProduct->admin_graphql_api_id = $productData['admin_graphql_api_id'];
            $existingProduct->save();
        } else {
            // Create a new product
            $newProduct = new Product();
            $newProduct->shopify_product_id = $productData['id'];
            $newProduct->title = $productData['title'];
            $newProduct->body_html = $productData['body_html'];
            $newProduct->vendor = $productData['vendor'];
            $newProduct->product_type = $productData['product_type'];
            $newProduct->handle = $productData['handle'];
            $newProduct->template_suffix = $productData['template_suffix'];
            $newProduct->published_scope = $productData['published_scope'];
            $newProduct->tags = $productData['tags'];
            $newProduct->status = $productData['status'];
            $newProduct->published_at = $productData['published_at'];
            $newProduct->admin_graphql_api_id = $productData['admin_graphql_api_id'];
            $newProduct->store_id = $store->id; // Assuming $store contains the store information
            $newProduct->save();
        }
    }
}
