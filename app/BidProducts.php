<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidProducts extends Model
{
    //

    protected $table = "bid_products";
    protected $primaryKey = 'bp_id';

    const CREATED_AT = 'bp_created_at';
    const UPDATED_AT = 'bp_updated_at';
}
