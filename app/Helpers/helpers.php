<?php
    use App\SubAccount;
    use App\VoucherDetail;

    if(!function_exists('getOpeningBalance')){
        function getOpeningBalance($subAccountID,$date,$specific=false,$id=0){
            $subAccount = SubAccount::where('id',$subAccountID)->first();
            $openingBalance = $subAccount->opening_balance;
            $transactionType = $subAccount->transaction_type;
            $vouchers = $specific?VoucherDetail::where('id','!=',$id)->where('sub_account_id',$subAccount->id)->whereDate('date', '<',$date)->get():VoucherDetail::where('sub_account_id',$subAccount->id)->whereDate('date', '<',$date)->get();
            if($vouchers->count() > 0){
                foreach($vouchers as $key=>$detail){
                    $str = $detail->entry_type."_amount";
                    if($transactionType=="debit" && $detail->entry_type=="debit"){
                        $openingBalance = $openingBalance + $detail->$str;
                        $transactionType = "debit";
                    } else if($transactionType=="credit" && $detail->entry_type=="debit"){
                        if($openingBalance >= $detail->$str){
                            $openingBalance = $openingBalance - $detail->$str;
                            $transactionType = "credit";
                        }else if($openingBalance < $detail->$str){
                            $openingBalance = $detail->$str - $openingBalance;
                            $transactionType = "debit";
                        }
                    } else if($transactionType=="credit" && $detail->entry_type=="credit"){
                        $openingBalance = $openingBalance + $detail->$str;
                        $transactionType = "credit";
                    } else if($transactionType=="debit" && $detail->entry_type=="credit"){
                        if($openingBalance >= $detail->$str){
                            $openingBalance = $openingBalance - $detail->$str;
                            $transactionType = "debit";
                        }else if($openingBalance < $detail->$str){
                            $openingBalance = $detail->$str - $openingBalance;
                            $transactionType = "credit";
                        }
                    }
                }
            }

            return ["opening_balance"=>$openingBalance,"opening_balance_type"=>$transactionType];
        }    
    }