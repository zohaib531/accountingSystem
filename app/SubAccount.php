<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubAccount extends Model
{
    use SoftDeletes;
    public function get_account()
    {
        return $this->belongsTo(Account::class,'account_id','id');
    }
}
