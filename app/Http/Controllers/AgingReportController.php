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
        $vouchers = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[$request->start_date, $request->end_date])->orderBy('date')->get();
        $totalDebit = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[$request->start_date, $request->end_date])->sum('debit_amount');
        $totalCredit = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[$request->start_date, $request->end_date])->sum('credit_amount');
        $subAccount = SubAccount::where('id', $request->sub_account)->first();
        return response()->json(['success' => true, 'html' => view('admin.reports.agingReport.get_data',compact('vouchers','totalDebit','totalCredit','subAccount'))->render()]);
    }
}
