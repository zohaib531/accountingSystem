<?php

namespace App\Http\Controllers;

use App\Account;
use App\SubAccount;
use App\VoucherDetail;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgingReportController extends Controller
{
    public function index()
    {
        $accounts = Account::select('id', 'title')->get();
        $subAccounts = SubAccount::select('id', 'title','account_id')->get();
        return view('admin.reports.agingReport.index',compact('accounts','subAccounts'));
    }


     // get data for trial balance
     public function entriesBetweenDates(Request $request){

        // $validations = Validator::make($request->all(), ['account'=>'required','sub_account'=>'required','start_date' => 'required_with_all:end_date','end_date' => 'required_with_all:start_date']);
        $validations = Validator::make($request->all(), ['account'=>'required','sub_account'=>'required','start_date' => 'required','end_date' => 'required']);
        if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}


        $start_date = Carbon::createFromFormat('d / m / y',  $request->start_date)->format('y-m-d');
        $end_date = Carbon::createFromFormat('d / m / y', $request->end_date)->format('y-m-d');

        if($request->account!="all" && $request->sub_account=="all"){
            $account = Account::where('id',$request->account)->first();
            $subAccounts = $account->get_sub_accounts()->pluck('id');
            $vouchers = VoucherDetail::whereIn('sub_account_id',$subAccounts)->whereBetween('date',[$start_date, $end_date])->get()->groupBy("sub_account_id");

        }else if($request->account!="all" && $request->sub_account!="all"){
            $vouchers = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[$start_date, $end_date])->get()->groupBy("sub_account_id");

        }else{
            $vouchers = VoucherDetail::whereBetween('date',[$start_date, $end_date])->get()->groupBy("sub_account_id");
        }

        $openingBalance = 0;
        $debitBalance = 0;
        $creditBalance = 0;
        $entryType = '';

        if($vouchers->count()>0){
            foreach($vouchers as $key=>$subAccountEntries){
                $subAccount = SubAccount::where('id',$key)->first();
                if($subAccountEntries->count()>0){
                    foreach ($subAccountEntries as $key => $singleEntry) {
                        if($key==0){
                            $getOpeningBalanceResponse = getOpeningBalance($singleEntry->sub_account_id,$singleEntry->date,true,$singleEntry->id);
                            $openingBalance = $getOpeningBalanceResponse["opening_balance"];
                            $entryType = $getOpeningBalanceResponse["opening_balance_type"];
                        }

                        $str = $singleEntry->entry_type."_amount";
                            if($openingBalance > 0 ){
                                $singleEntry->entry_type=="debit"?$debitBalance += $singleEntry->$str:$creditBalance += $singleEntry->$str;
                                $openingBalance = $openingBalance - $singleEntry->$str;
                            }else{
                                $entryType = $entryType=="debit"? "credit":"debit";
                            }
                            $to = Carbon::createFromFormat('Y-m-d', $singleEntry->date);
                            $from = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $diff_in_days = $to->diffInDays($from);
                    }
                }
            }
        }else{
            return "so";
        }
        return $vouchers;
        // $subAccount = getOpeningBalance($request->sub_account,date("y-m-d"),false,0);
        // $totalDebit = VoucherDetail::where('sub_account_id',$request->sub_account)->where('entry_type', $subAccount["opening_balance_type"])->whereDate('date', '<=',date("Y-m-d"))->sum('debit_amount');
        // $totalCredit = VoucherDetail::where('sub_account_id',$request->sub_account)->where('entry_type', $subAccount["opening_balance_type"])->whereDate('date', '<=',date("Y-m-d"))->sum('credit_amount');
        return response()->json(['success' => true, 'html' => view('admin.reports.agingReport.get_data',compact('vouchers','start_date','end_date'))->render()]);

    }


}
