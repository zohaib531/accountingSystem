<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailVoucher extends Model
{
    public function voucher(){
        return $this->belongsTo(Voucher::class,'voucher_id','id');
    }
}
