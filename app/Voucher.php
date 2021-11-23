<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    public function voucherDetails(){
        return $this->hasMany(VoucherDetail::class,'voucher_id','id');
    }
}
