<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class JournalVoucherDetail extends Model
{
    use SoftDeletes;

    public function voucher(){
        return $this->belongsTo(JournalVoucher::class,'voucher_id','id');
    }
}
