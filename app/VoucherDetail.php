<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherDetail extends Model
{
    use SoftDeletes;

    public function voucher(){
        return $this->belongsTo(Voucher::class,'voucher_id','id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function subAccount(){
        return $this->belongsTo(SubAccount::class,'sub_account_id','id');
    }

}
