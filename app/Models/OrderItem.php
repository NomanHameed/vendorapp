<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'store_id',
        'order_id',
        'lineitem_id',
        'shopify_product_id',
        'variant_id',
        'name',
        'quantity',
        'sku',
        'vendor',
        'fulfillment_service',
        'requires_shipping',
        'taxable',
        'grams',
        'price',
        'total_discount',
        'fulfillment_status'
    ];
}
