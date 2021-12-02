<?php

namespace App\Http\Controllers;

use App\SubAccount;
use App\VoucherDetail;
use Validator;
use Illuminate\Http\Request;

class AgingReportController extends Controller
{
    public function index()
    {
        $subAccounts = SubAccount::select('id', 'title')->get();
        return view('admin.reports.agingReport.index',compact('subAccounts'));
    }


     // get data for trial balance
     public function entriesBetweenDates(Request $request){
        $validations = Validator::make($request->all(), ['sub_account'=>'required']);
        if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}
        $subAccount = SubAccount::where('id', $request->sub_account)->first();
        $vouchers = VoucherDetail::where('sub_account_id',$request->sub_account)->where('entry_type', $subAccount->transaction_type)->whereDate('date', '<=',date("Y-m-d"))->orderBy('date','desc')->get();
        $totalDebit = VoucherDetail::where('sub_account_id',$request->sub_account)->where('entry_type', $subAccount->transaction_type)->whereDate('date', '<=',date("Y-m-d"))->sum('debit_amount');
        $totalCredit = VoucherDetail::where('sub_account_id',$request->sub_account)->where('entry_type', $subAccount->transaction_type)->whereDate('date', '<=',date("Y-m-d"))->sum('credit_amount');
        return response()->json(['success' => true, 'html' => view('admin.reports.agingReport.get_data',compact('vouchers','totalDebit','totalCredit','subAccount'))->render()]);
    }
}
