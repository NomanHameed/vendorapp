<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSettings extends Model
{
    protected $fillable = [
        'store_id',
        'account_number',
        'api_key',
        'profile_email',

        'profile_type',
        'is_canada',
        'order_active',
        'update_active',
        'new_product',
        'margin_type',
        'price_margin',
        'import_cats',
        'import_brands'
    ];
    
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }
}
