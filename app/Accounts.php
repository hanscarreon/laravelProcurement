<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    //
    protected $table = "accounts";
    protected $primaryKey = 'ac_id';
    protected $email = 'ac_email';

    const CREATED_AT = 'ac_created_at';
    const UPDATED_AT = 'ac_updated_at';
}
