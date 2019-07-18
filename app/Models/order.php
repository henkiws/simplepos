<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'unique_id', 'product_id', 'user_id', 'order_qty', 'order_price', 'order_price_total', 'payment_date', 'payment_type', 'customer_name'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];


}
