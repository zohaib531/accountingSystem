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
        $start_date = '';
        $end_date = '';
        // $validations = Validator::make($request->all(), ['account'=>'required','sub_account'=>'required','start_date' => 'required_with_all:end_date','end_date' => 'required_with_all:start_date']);
        $validations = Validator::make($request->all(), ['account'=>'required','sub_account'=>'required','start_date' => 'required','end_date' => 'required']);
        if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}

        if( $request->start_date !== ''){
            $start_date = Carbon::createFromFormat('d / m / y',  $request->start_date)->format('y-m-d');
        }

        if($request->end_date !== ''){
            $end_date = Carbon::createFromFormat('d / m / y', $request->end_date)->format('y-m-d');
        }

        if($request->sub_account!="all" && $request->sub_account!=""){
            // $vouchers = VoucherDetail::where("sub_account_id",$request->sub_account)->whereBetween('date',[Carbon::createFromFormat('d / m / y', $request->start_date)->format('y-m-d'), Carbon::createFromFormat('d / m / y', $request->end_date)->format('y-m-d')]);
            $vouchers = VoucherDetail::where("sub_account_id",$request->sub_account)->whereBetween('date',[$start_date, $end_date]);

        }else{

            $vouchers = VoucherDetail::whereBetween('date',[$start_date, $end_date]);

        }

        $vouchers =$vouchers->get();
        // return $vouchers;
        $subAccount = getOpeningBalance($request->sub_account,date("y-m-d"),false,0);
        $totalDebit = VoucherDetail::where('sub_account_id',$request->sub_account)->where('entry_type', $subAccount["opening_balance_type"])->whereDate('date', '<=',date("Y-m-d"))->sum('debit_amount');
        $totalCredit = VoucherDetail::where('sub_account_id',$request->sub_account)->where('entry_type', $subAccount["opening_balance_type"])->whereDate('date', '<=',date("Y-m-d"))->sum('credit_amount');
        return response()->json(['success' => true, 'html' => view('admin.reports.agingReport.get_data',compact('vouchers','totalDebit','totalCredit','subAccount','start_date','end_date'))->render()]);

    }


}
