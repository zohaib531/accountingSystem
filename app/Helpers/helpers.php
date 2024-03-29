<?php
    use App\SubAccount;
    use App\VoucherDetail;

    // if(!function_exists('getOpeningBalance')){
    //     function getOpeningBalance($subAccountID,$startDate = null, $endDate, $specific=false,$id=0){
    //         $subAccount = SubAccount::where('id',$subAccountID)->first();
    //         $openingBalance = $subAccount->opening_balance;
    //         $transactionType = $subAccount->transaction_type;
    //         $vouchers = $specific?VoucherDetail::where('id','!=',$id)->where('sub_account_id',$subAccount->id)->whereBetween('date',[$startDate, $endDate])->get():VoucherDetail::where('sub_account_id',$subAccount->id)->whereBetween('date',[$startDate, $endDate])->get();
    //         if($vouchers->count() > 0){
    //             foreach($vouchers as $key=>$detail){
    //                 $str = $detail->entry_type."_amount";
    //                 if($transactionType=="debit" && $detail->entry_type=="debit"){
    //                     $openingBalance = $openingBalance + $detail->$str;
    //                     $transactionType = "debit";
    //                 } else if($transactionType=="credit" && $detail->entry_type=="debit"){
    //                     if($openingBalance >= $detail->$str){
    //                         $openingBalance = $openingBalance - $detail->$str;
    //                         $transactionType = "credit";
    //                     }else if($openingBalance < $detail->$str){
    //                         $openingBalance = $detail->$str - $openingBalance;
    //                         $transactionType = "debit";
    //                     }
    //                 } else if($transactionType=="credit" && $detail->entry_type=="credit"){
    //                     $openingBalance = $openingBalance + $detail->$str;
    //                     $transactionType = "credit";
    //                 } else if($transactionType=="debit" && $detail->entry_type=="credit"){
    //                     if($openingBalance >= $detail->$str){
    //                         $openingBalance = $openingBalance - $detail->$str;
    //                         $transactionType = "debit";
    //                     }else if($openingBalance < $detail->$str){
    //                         $openingBalance = $detail->$str - $openingBalance;
    //                         $transactionType = "credit";
    //                     }
    //                 }
    //             }
    //         }

    //         return ["opening_balance"=>$openingBalance,"opening_balance_type"=>$transactionType];
    //     }
    // }

     //Code for partyLedger opening balance
     if(!function_exists('getOpeningBalance')){
        function getOpeningBalance($subAccountID,$startDate = null, $endDate, $specific=false,$id=0){

            $subAccount = SubAccount::where('id',$subAccountID)->first();
            $openingBalance = $subAccount->opening_balance;
            $transactionType = $subAccount->transaction_type;

            if($startDate == null && $endDate != null){
                // $vouchers = $specific?VoucherDetail::where('id','!=',$id)->where('sub_account_id',$subAccount->id)->whereDate('date','<=', $endDate)->get():VoucherDetail::where('sub_account_id',$subAccount->id)->whereBetween('date',[$startDate, $endDate])->get();
                $vouchers = $specific?VoucherDetail::where('id','!=',$id)->where('sub_account_id',$subAccount->id)->whereDate('date','<=', $endDate)->get():VoucherDetail::where('sub_account_id',$subAccount->id)->whereDate('date','<=', $endDate)->get();
            }
            if($endDate == null && $startDate != null){
                $vouchers = $specific?VoucherDetail::where('id','!=',$id)->where('sub_account_id',$subAccount->id)->whereDate('date','>=', $startDate)->get():VoucherDetail::where('sub_account_id',$subAccount->id)->whereBetween('date',[$startDate, $endDate])->get();
            }
            if($endDate != null && $startDate != null){
                $vouchers = $specific?VoucherDetail::where('id','!=',$id)->where('sub_account_id',$subAccount->id)->whereBetween('date',[$startDate, $endDate])->get():VoucherDetail::where('sub_account_id',$subAccount->id)->whereBetween('date',[$startDate, $endDate])->get();
            }

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



    if(!function_exists('getBalanceAndType')){
        function getBalanceAndType($openingBalance,$transactionType,$entryType,$amount){
            if($transactionType=="debit" && $entryType=="debit"){
                $openingBalance = $openingBalance + $amount;
                $transactionType = "debit";
            } else if($transactionType=="credit" && $entryType=="debit"){
                if($openingBalance >= $amount){
                    $openingBalance = $openingBalance - $amount;
                    $transactionType = "credit";
                }else if($openingBalance < $amount){
                    $openingBalance = $amount - $openingBalance;
                    $transactionType = "debit";
                }
            } else if($transactionType=="credit" && $entryType=="credit"){
                $openingBalance = $openingBalance + $amount;
                $transactionType = "credit";
            } else if($transactionType=="debit" && $entryType=="credit"){
                if($openingBalance >= $amount){
                    $openingBalance = $openingBalance - $amount;
                    $transactionType = "debit";
                }else if($openingBalance < $amount){
                    $openingBalance = $amount - $openingBalance;
                    $transactionType = "credit";
                }
            }
            return ["balance"=>$openingBalance,"type"=>$transactionType];
        }

    }

    if(!function_exists('getFilledField')){
        function getFilledField($array){
            $newArr = [];
            foreach($array as $x=>$value)
            {
              if($value!="all" && $value != ''){
                $newArr[$x] = $value;
              }
            }
            return $newArr;
        }
    }
