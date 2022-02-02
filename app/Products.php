<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $table = "products";
    protected $primaryKey = 'product_id';

    const CREATED_AT = 'product_created_at';
    const UPDATED_AT = 'product_updated_at';
}
