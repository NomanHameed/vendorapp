<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderCustomer extends Model
{
    protected $table = 'order_customers';

    protected $fillable = [
        'store_id',
        'order_id',
        'customer_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'tags',
        'orders_count',
        'state',
        'total_spent',
        'company',
        'address1',
        'address2',
        'city',
        'province',
        'country',
        'zip'
    ];
}
