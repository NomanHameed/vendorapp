<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderBillingAddress extends Model
{
    protected $table = 'order_billing_addresses';

    protected $fillable = [
        'store_id',
        'order_id',
        'billing_name',
        'billing_phone',
        'billing_company',
        'billing_address1',
        'billing_address2',
        'billing_city',
        'billing_province',
        'billing_province_code',
        'billing_country',
        'billing_country_code',
        'billing_zip',
        'billing_latitude',
        'billing_longitude'
    ];
}
