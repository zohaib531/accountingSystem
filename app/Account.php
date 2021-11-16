<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    public function get_sub_accounts()
    {
        return $this->hasMany(SubAccount::class, 'account_id','id');
    }
}
