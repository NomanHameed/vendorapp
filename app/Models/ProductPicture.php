<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'shopify_product_image_id',
        'shopify_product_id',
        'alt',
        'admin_graphql_api_id',
        'width',
        'height',
        'src',
        'variant_ids'
    ];
    protected $casts = [
        'variant_ids' => 'array',
    ];
}
