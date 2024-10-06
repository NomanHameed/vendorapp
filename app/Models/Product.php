<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
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

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(ProductOptions::class, 'product_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public static function manageProduct($productData, $store)
    {
        $data = $productData;
        $data['shopify_product_id'] = $data['id'];
        $data['store_id'] = $store->id;
        $vendor = User::where('vendor_name', $data['vendor'])->first();
        $data['vendor'] = ($vendor) ? $vendor->id : $productData['vendor'];

        unset($data['id'], $data['product_id']);
        $product = Product::updateOrCreate([
            'shopify_product_id' => $productData['id']
        ], $data);
        foreach ($productData['variants'] as $variant) {
            $data1 = $variant;
            $data1['product_variant_id'] = $data1['id'];
            $data1['shopify_product_id'] = $data1['product_id'];
            unset($data1['id'], $data1['product_id']);
            $data1['product_id'] = $product->id;
            ProductVariant::updateOrCreate(
                [
                    'product_variant_id' => $variant['id'],
                    'shopify_product_id' => $variant['product_id']
                ],
                $data1
            );
        }
        foreach ($productData['options'] as $option) {
            $data2 = $option;
            $data2['shopify_option_id'] = $data2['id'];
            $data2['shopify_product_id'] = $data2['product_id'];
            unset($data['id'], $data2['product_id']);
            $data2['product_id'] = $product->id;
            ProductOptions::updateOrCreate(
                [
                    'shopify_option_id' => $option['id'],
                    'shopify_product_id' => $option['product_id']
                ],
                $data2
            );
        }
        foreach ($productData['images'] as $image) {
            $data3 = $image;
            $data3['shopify_product_image_id'] = $data3['id'];
            $data3['shopify_product_id'] = $data3['product_id'];
            unset($data3['id'], $data3['product_id']);
            $data3['product_id'] = $product->id;
            ProductImage::updateOrCreate(
                [
                    'shopify_product_image_id' => $image['id'],
                    'shopify_product_id' => $image['product_id']
                ],
                $data3
            );
        }
        if ($productData['image']) {
            $data4 = $productData['image'];
            $data4['shopify_product_image_id'] = $data4['id'];
            $data4['shopify_product_id'] = $data4['product_id'];
            unset($data4['id'], $data4['product_id']);
            $data4['product_id'] = $product->id;
            ProductPicture::updateOrCreate(
                [
                    'shopify_product_image_id' => $image['id'],
                    'shopify_product_id' => $image['product_id']
                ],
                $data4
            );
        }
    }
}
