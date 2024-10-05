<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'shopify_product_id',
        'name',
        'position',
        'value'
    ];

    protected $casts = [
        'values' => 'array',
    ];
}
