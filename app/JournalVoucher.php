<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalVoucher extends Model
{
    use SoftDeletes;

    public function get_debit_subaccount()
    {
        return $this->belongsTo(SubAccount::class, 'debit_account_id','id');
    }

    public function get_credit_subaccount()
    {
        return $this->belongsTo(SubAccount::class, 'credit_account_id','id');
    }
    
}
