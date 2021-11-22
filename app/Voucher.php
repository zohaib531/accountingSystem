<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    public function voucherDetails(){
        return $this->hasMany(DetailVoucher::class,'voucher_id','id');
    }
}
