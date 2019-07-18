<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{	
	use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'product_code', 'product_name', 'product_slug', 'product_img', 'product_description', 'stock'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

}
