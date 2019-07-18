<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_price extends Model
{
    protected $table = 'product_price';

    protected $fillable = [
        'product_id', 'currency', 'original_price', 'markup_price', 'discount_percent', 'publish_price'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

}
