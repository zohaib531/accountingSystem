<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function voucherProducts()
    {
        return $this->hasMany(VoucherDetail::class, 'product_id','id');
    }
}
