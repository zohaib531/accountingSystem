<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    public function voucherDetails(){
        return $this->hasMany(VoucherDetail::class,'voucher_id','id');
    }
}
