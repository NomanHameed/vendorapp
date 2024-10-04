<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderShippingAddress extends Model
{
    protected $table = 'order_shipping_addresses';

    protected $fillable = [
        'store_id',
        'order_id',
        'name',
        'phone',
        'company',
        'address1',
        'address2',
        'city',
        'province',
        'province_code',
        'country',
        'country_code',
        'zip',
        'latitude',
        'longitude'
    ];
}
