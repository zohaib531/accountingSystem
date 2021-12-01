<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Voucher;
use App\SubAccount;

class TrialBalance extends Controller
{
    public function index()
    { 
        $subAccounts = SubAccount::select('id', 'title')->get();
        return view('admin.reports.trial_balance.index',compact('subAccounts'));
    }

    // get data for trial balance
    public function entriesBetweenDates(Request $request){
        $validations = Validator::make($request->all(), ['start_date' => 'required','end_date' => 'required|after_or_equal:start_date',]);
        if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}
        $vouchers = Voucher::whereBetween('date',[$request->start_date, $request->end_date])->get();
        return response()->json(['success' => true, 'html' => view('admin.reports.trial_balance.get_data',compact('vouchers'))->render()]);
    }
}
